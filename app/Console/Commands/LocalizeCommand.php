<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SplFileInfo;

class LocalizeCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'app:localize-command';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  protected array $currentWords = [];

  protected array $newWords = [];
  /**
   * Execute the console command.
   */

  public function handle()
  {
    $this->currentWords = $this->getCurrentWords();
    $files = $this->getAllFiles();
    $regex = collect([
      "/__\(['\"].*?['\"]\)/",
      "/@lang\(['\"].*?['\"]\)/",
    ]);

    $files->each(function (SplFileInfo $file) use ($regex) {
      $regex->each(fn(string $i) => $this->extractor($file, $i));
    });

    $this->generateFile();

    return 0;
  }

  private function extractor($file, $regex): void
  {
    $handler = function (string $line) {
      $word = (string)Str::of($line)
        ->replace("@lang('", '')
        ->replace('@lang("', '')
        ->replace("__('", '')
        ->replace("')", '')
        ->replace('__("', '')
        ->replace('")', '');

      if (!isset($this->currentWords[$word])) {
        $this->newWords[$word] = '';
      }
    };

    Str::of($file->getContents())->matchAll($regex)->each($handler);
  }

  private function getAllFiles(): Collection
  {
    return collect([
      resource_path('views'),
      resource_path('sidebar'),
      app_path(),
      config_path()
    ])
      ->transform(fn($folder) => File::allFiles($folder))
      ->flatten(1)
      ->reject(fn($file) => $file->getFileName() === 'LocalizeCommand.php');
  }

  private function getCurrentWords()
  {
    $path = base_path('lang/ar.json');

    return !File::exists($path) ?
      [] : json_decode(file_get_contents($path), true);
  }

  private function generateFile()
  {
    $file = 'hsm_locale_' . time() . '.json';
    file_put_contents(
      base_path('lang/' . $file),
      json_encode($this->newWords, JSON_PRETTY_PRINT)
    );

    $this->info("exporting language done successfully {$file}");
  }
}
