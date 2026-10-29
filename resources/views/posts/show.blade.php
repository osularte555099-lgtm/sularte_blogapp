@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <article class="article">
        <h1>{{ $post->title }}</h1>
        <div class="byline">
            Posted {{ $post->created_at->format('F j, Y') }}
            @if($post->updated_at->gt($post->created_at->addMinute()))
                (edited {{ $post->updated_at->diffForHumans() }})
            @endif
        </div>

        <div class="content">{{ $post->body }}</div>

        <div class="article-foot">
            <a class="btn btn-quiet" href="{{ route('posts.index') }}">Back to posts</a>
            <a class="btn" href="{{ route('posts.edit', $post->id) }}">Edit post</a>
        </div>
    </article>
@endsection