<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateToArabic extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'app:translate-to-arabic';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $file = File::get(base_path('lang' . DIRECTORY_SEPARATOR . 'trans.json'));
    $translations = [];
    foreach (json_decode($file) as $key => $value) {
      $translations[$key] = GoogleTranslate::trans($key, 'ar');
    }

    Storage::disk('local')->put('ar.json', json_encode($translations, JSON_UNESCAPED_UNICODE));
    return Command::SUCCESS;
  }
}
