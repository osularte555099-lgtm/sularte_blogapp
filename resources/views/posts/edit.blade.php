@extends('layouts.app')

@section('title', 'Edit post')

@section('content')
    <div class="page-head">
        <h1>Edit post</h1>
        <p class="sub">Changes are saved as soon as you update.</p>
    </div>

    <form class="panel" action="{{ route('posts.update', $post->id) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <div class="field @error('title') has-error @enderror">
            <label for="title">Title</label>
            <input id="title" type="text" name="title" value="{{ old('title', $post->title) }}">
            @error('title')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <div class="field @error('body') has-error @enderror">
            <label for="body">Body</label>
            <textarea id="body" name="body">{{ old('body', $post->body) }}</textarea>
            @error('body')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Save changes</button>
            <a class="btn btn-quiet" href="{{ route('posts.index') }}">Cancel</a>
        </div>
    </form>
@endsection