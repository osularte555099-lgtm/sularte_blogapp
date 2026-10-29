@extends('layouts.app')

@section('title', 'All posts')

@section('content')
    <div class="page-head">
        <h1>Latest posts</h1>
        <p class="sub">{{ $posts->count() }} {{ Str::plural('post', $posts->count()) }}</p>
    </div>

    @forelse($posts as $post)
        <article class="post-row">
            <a class="post-title" href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
            <p class="excerpt">{{ Str::limit($post->body, 180) }}</p>

            <div class="post-meta">
                <time datetime="{{ $post->created_at->toDateString() }}">
                    {{ $post->created_at->format('M j, Y') }}
                </time>

                <div class="actions">
                    <a class="link-btn" href="{{ route('posts.show', $post->id) }}">Read</a>
                    <a class="link-btn" href="{{ route('posts.edit', $post->id) }}">Edit</a>

                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                          onsubmit="return confirm('Delete this post? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="link-btn danger">Delete</button>
                    </form>
                </div>
            </div>
        </article>
    @empty
        <div class="empty">
            <h2>No posts yet</h2>
            <p>Write your first post and it will show up here.</p>
            <a class="btn" href="{{ route('posts.create') }}">Write a post</a>
        </div>
    @endforelse
@endsection