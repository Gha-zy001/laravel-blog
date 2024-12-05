@extends('layouts.master')
@section('title', 'Home')

@section('content')
    <header class="py-5 bg-light border-bottom mb-4">
        <div class="container">
            <div class="text-center my-5">
                <h1 class="fw-bolder">{{ __('welcome') }} </h1>
                @if (auth()->check())
                    <a class="btn btn-primary btn-lg" type="button" href="{{ route('posts.create') }}">@lang('translate.create_post')</a>
                @endif
            </div>
        </div>
    </header>
    <!-- Page content-->
    <div class="row">
        <!-- Blog entries-->
        <div class="col-lg-8">
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-6">
                        <!-- Blog post-->
                        <div class="card mb-4 ">
                            @if (auth()->id() && auth()->id() == $post->user_id)
                                <a href="{{ route('posts.edit', $post->id) }}">
                                    <img class="card-img-top" src="{{ asset($post->image_path) }}" alt="..." />
                                </a>
                            @else
                                <img class="card-img-top" src="{{ asset($post->image_path) }}" alt="..." />
                            @endif


                            <div class="card-body">
                                <div class="small text-muted">{{ $post->created_at->diffforhumans() }} </div>
                                <h2 class="card-title h4">{{ $post->title }}</h2>
                                <p class="card-text">{{ substr($post->content, 0, 20) }} </br> <small> created by :
                                        {{ $post->user->name }} </small></p>
                                @if (count($post->categories) > 0)
                                    @foreach ($post->categories as $category)
                                        <span class="badge bg-secondary text-white mb-2">{{ $category->name }}</span>
                                    @endforeach
                                @endif
                                </br>

                                <a class="btn btn-primary" href="{{ route('posts.show', $post->id) }}">Read more →</a>
                                @if (auth()->id() && auth()->id() == $post->user_id)
                                    <a class="btn btn-danger" href="#"
                                        onclick="event.preventDefault();
                                document.getElementById('delete-post-{{ $post->id }}').submit();">Delete</a>
                                    <form id="delete-post-{{ $post->id }}"
                                        action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach



            </div>
            <!-- Pagination-->
            {{-- <nav aria-label="Pagination">
                <hr class="my-0" />
                <ul class="pagination justify-content-center my-4">
                    <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Newer</a></li>
                    <li class="page-item active" aria-current="page"><a class="page-link" href="#!">1</a></li>
                    <li class="page-item"><a class="page-link" href="#!">2</a></li>
                    <li class="page-item"><a class="page-link" href="#!">3</a></li>
                    <li class="page-item disabled"><a class="page-link" href="#!">...</a></li>
                    <li class="page-item"><a class="page-link" href="#!">15</a></li>
                    <li class="page-item"><a class="page-link" href="#!">Older</a></li>
                </ul>
            </nav> --}}
            {{ $posts->links('layouts.components.pagination') }}
        </div>
        <!-- Side widgets-->
        <div class="col-lg-4">
            <!-- Search widget-->
            <div class="card mb-4">
                <div class="card-header">Search</div>
                <div class="card-body">
                    <div class="input-group">
                        <form method="GET" action={{ route('home') }}>
                            <input class="form-control" type="text" placeholder="Enter search term..."
                                aria-label="Enter search term..." aria-describedby="button-search" name="search"
                                value="{{ request('search') }}">
                            <button class="btn btn-primary" id="button-search" type="submit">Go!</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Categories widget-->
            <div class="card mb-4">
                <div class="card-header">Categories</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#!">Web Design</a></li>

                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#!">JavaScript</a></li>
                                <li><a href="#!">CSS</a></li>
                                <li><a href="#!">Tutorials</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <!-- Side widget-->
            <div class="card mb-4">
                <div class="card-header">Side Widget</div>
                <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
            </div> --}}
        </div>
    </div>
@endsection
