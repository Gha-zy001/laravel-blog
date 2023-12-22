@extends('layouts.master')
@section('title', 'Create Post')
@section('content')
    <h3>Create New Post </h2>
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">title</label>
                <input type="text" class="form-control" id="title" name="title" value={{ old('title') }}>
                @error('title')
                    <p class="text-danger"> {{ $message }} </p>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">content</label>
                <textarea class="form-control" id="content" name="content" rows="3">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-danger"> {{ $message }} </p>
                @enderror
            </div>
            {{-- @DD(old('categories')) --}}
            @foreach ($categories as $category)
                <input type="checkbox" name="categories[]" value="{{ $category->id }}" id="{{ $category->id }}"  {{in_array($category->id,old('categories') ?? []) ? "checked": ''}}
                <label for="{{ $category->id }}">{{ $category->name }}</label>
                <br>
            @endforeach

            <div class="form-group">
                <label for="image">image</label>
                <input type="file" class="form-control" id="image" name="image">
                @error('image')
                    <p class="text-danger"> {{ $message }} </p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3 mb-3">Create</button>
        </form>
    @endsection
