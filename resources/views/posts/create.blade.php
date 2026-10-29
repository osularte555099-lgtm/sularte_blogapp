@extends('layouts.app')

@section('title', 'New post')

@push('styles')
<style>
    .editor { padding: 0; overflow: hidden; }

    .editor-tabs {
        display: flex;
        gap: 4px;
        padding: 0 16px;
        border-bottom: 1px solid var(--line);
        background: #f8f9fc;
    }
    .tab {
        font-family: var(--ui);
        font-weight: 500;
        font-size: 0.95rem;
        background: none;
        border: 0;
        padding: 14px 14px 12px;
        cursor: pointer;
        color: var(--muted);
        border-bottom: 3px solid transparent;
    }
    .tab:hover { color: var(--ink); }
    .tab[aria-selected="true"] {
        color: var(--ink);
        border-bottom-color: var(--accent);
    }

    .editor-body { padding: 28px; }

    .field input.title-input {
        font-family: var(--ui);
        font-size: clamp(1.6rem, 5vw, 2.2rem);
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1.2;
        padding: 6px 0 12px;
        border: 0;
        border-bottom: 2px solid var(--line);
        border-radius: 0;
        background: transparent;
    }
    .field input.title-input::placeholder { color: #a5aec2; }
    .field input.title-input:focus {
        outline: none;
        border-bottom-color: var(--accent);
    }
    .field.has-error input.title-input { background: transparent; }

    .field textarea.body-input {
        border: 0;
        padding: 0;
        min-height: 320px;
        font-size: 1.125rem;
        line-height: 1.8;
        background: transparent;
    }
    .field textarea.body-input:focus { outline: none; }
    .field.has-error textarea.body-input { background: transparent; }

    .counter {
        font-family: var(--ui);
        font-size: 0.85rem;
        color: var(--muted);
        text-align: right;
        margin-top: 6px;
    }

    .editor-foot {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px 28px;
        border-top: 1px solid var(--line);
        background: #f8f9fc;
    }
    .editor-foot .stats {
        font-family: var(--ui);
        font-size: 0.9rem;
        color: var(--muted);
    }

    .preview-empty { color: var(--muted); font-style: italic; }

    [hidden] { display: none !important; }

    @media (max-width: 520px) {
        .editor-body { padding: 20px; }
        .editor-foot { padding: 14px 20px; }
    }
</style>
@endpush

@section('content')
    <div class="page-head">
        <h1>Write a post</h1>
        <p class="sub">Write first, then check the Preview tab to see how it will read.</p>
    </div>

    <form class="panel editor" action="{{ route('posts.store') }}" method="POST" novalidate>
        @csrf

        <div class="editor-tabs" role="tablist">
            <button type="button" class="tab" id="tab-write" role="tab" aria-selected="true" aria-controls="pane-write">Write</button>
            <button type="button" class="tab" id="tab-preview" role="tab" aria-selected="false" aria-controls="pane-preview">Preview</button>
        </div>

        {{-- WRITE --}}
        <div class="editor-body" id="pane-write" role="tabpanel" aria-labelledby="tab-write">
            <div class="field @error('title') has-error @enderror">
                <label for="title" class="sr-only" style="position:absolute;left:-9999px;">Title</label>
                <input id="title" class="title-input" type="text" name="title"
                       value="{{ old('title') }}" maxlength="255"
                       placeholder="Post title" autofocus>
                <div class="counter"><span id="title-count">0</span>/255</div>
                @error('title')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="field @error('body') has-error @enderror" style="margin-bottom:0;">
                <label for="body" class="sr-only" style="position:absolute;left:-9999px;">Body</label>
                <textarea id="body" class="body-input" name="body"
                          placeholder="Start writing here...">{{ old('body') }}</textarea>
                @error('body')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- PREVIEW --}}
        <div class="editor-body article" id="pane-preview" role="tabpanel" aria-labelledby="tab-preview" hidden>
            <h1 id="preview-title"></h1>
            <div class="byline">Preview - not published yet</div>
            <div class="content" id="preview-body"></div>
        </div>

        <div class="editor-foot">
            <span class="stats" id="word-count">0 words</span>
            <div class="form-actions">
                <a class="btn btn-quiet" href="{{ route('posts.index') }}">Cancel</a>
                <button type="submit" class="btn">Publish post</button>
            </div>
        </div>
    </form>

    <script>
        (function () {
            var title = document.getElementById('title');
            var body = document.getElementById('body');
            var titleCount = document.getElementById('title-count');
            var wordCount = document.getElementById('word-count');

            var tabWrite = document.getElementById('tab-write');
            var tabPreview = document.getElementById('tab-preview');
            var paneWrite = document.getElementById('pane-write');
            var panePreview = document.getElementById('pane-preview');
            var previewTitle = document.getElementById('preview-title');
            var previewBody = document.getElementById('preview-body');

            function updateCounts() {
                titleCount.textContent = title.value.length;
                var text = body.value.trim();
                var words = text ? text.split(/\s+/).length : 0;
                wordCount.textContent = words + (words === 1 ? ' word' : ' words');
            }

            function show(which) {
                var preview = which === 'preview';
                paneWrite.hidden = preview;
                panePreview.hidden = !preview;
                tabWrite.setAttribute('aria-selected', String(!preview));
                tabPreview.setAttribute('aria-selected', String(preview));

                if (preview) {
                    previewTitle.textContent = title.value.trim() || 'Untitled post';
                    if (body.value.trim()) {
                        previewBody.textContent = body.value;
                        previewBody.classList.remove('preview-empty');
                    } else {
                        previewBody.textContent = 'Nothing to preview yet.';
                        previewBody.classList.add('preview-empty');
                    }
                }
            }

            title.addEventListener('input', updateCounts);
            body.addEventListener('input', updateCounts);
            tabWrite.addEventListener('click', function () { show('write'); });
            tabPreview.addEventListener('click', function () { show('preview'); });

            updateCounts();
        })();
    </script>
@endsection