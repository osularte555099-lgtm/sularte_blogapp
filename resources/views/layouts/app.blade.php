<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Posts') - Sularte Blog</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@500;700&family=Source+Serif+4:wght@400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #f2f4f8;
            --paper: #ffffff;
            --ink: #16213a;
            --muted: #5d6a85;
            --line: #dde2ec;
            --accent: #0f766e;
            --accent-dark: #0b5b55;
            --danger: #b42318;
            --danger-bg: #fdecea;
            --ok-bg: #e3f5ef;
            --ui: "Bricolage Grotesque", "Segoe UI", system-ui, sans-serif;
            --read: "Source Serif 4", Georgia, "Times New Roman", serif;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--ink);
            font-family: var(--read);
            font-size: 1.0625rem;
            line-height: 1.7;
        }

        a { color: inherit; }

        :focus-visible {
            outline: 3px solid var(--accent);
            outline-offset: 2px;
            border-radius: 4px;
        }

        /* ---------- Top bar ---------- */
        .topbar {
            background: var(--ink);
            color: #fff;
        }
        .topbar-inner {
            max-width: 760px;
            margin: 0 auto;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        .brand {
            font-family: var(--ui);
            font-weight: 700;
            font-size: 1.2rem;
            letter-spacing: -0.01em;
            text-decoration: none;
        }

        /* ---------- Page ---------- */
        .page {
            max-width: 760px;
            margin: 0 auto;
            padding: 40px 20px 80px;
        }
        .page-head {
            margin-bottom: 28px;
        }
        .page-head h1 {
            font-family: var(--ui);
            font-size: clamp(1.9rem, 5vw, 2.6rem);
            line-height: 1.15;
            letter-spacing: -0.02em;
            margin: 0 0 6px;
        }
        .sub {
            margin: 0;
            color: var(--muted);
            font-family: var(--ui);
            font-size: 0.95rem;
        }

        /* ---------- Buttons ---------- */
        .btn {
            display: inline-block;
            font-family: var(--ui);
            font-weight: 500;
            font-size: 0.95rem;
            line-height: 1;
            padding: 11px 18px;
            border-radius: 8px;
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            background: var(--accent);
            color: #fff;
        }
        .btn:hover { background: var(--accent-dark); }
        .btn-quiet {
            background: transparent;
            color: var(--ink);
            border-color: var(--line);
        }
        .btn-quiet:hover { background: #e8ecf4; }
        .topbar .btn { background: #fff; color: var(--ink); }
        .topbar .btn:hover { background: #dfe6f3; }

        /* ---------- Flash + errors ---------- */
        .flash {
            font-family: var(--ui);
            background: var(--ok-bg);
            border-left: 4px solid var(--accent);
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 24px;
            font-size: 0.95rem;
        }

        /* ---------- Post list ---------- */
        .post-row {
            padding: 26px 0;
            border-top: 1px solid var(--line);
        }
        .post-row:last-child { border-bottom: 1px solid var(--line); }
        .post-title {
            font-family: var(--ui);
            font-weight: 700;
            font-size: 1.4rem;
            line-height: 1.25;
            letter-spacing: -0.01em;
            text-decoration: none;
        }
        .post-title:hover { color: var(--accent); }
        .excerpt {
            margin: 8px 0 14px;
            color: #34415e;
            max-width: 68ch;
        }
        .post-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            font-family: var(--ui);
            font-size: 0.9rem;
            color: var(--muted);
        }
        .actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .actions form { margin: 0; }
        .link-btn {
            background: none;
            border: 0;
            padding: 0;
            font: inherit;
            color: var(--accent);
            cursor: pointer;
            text-decoration: underline;
            text-underline-offset: 3px;
        }
        .link-btn.danger { color: var(--danger); }

        /* ---------- Empty state ---------- */
        .empty {
            background: var(--paper);
            border: 1px dashed #b9c2d4;
            border-radius: 12px;
            padding: 48px 24px;
            text-align: center;
            font-family: var(--ui);
        }
        .empty h2 { margin: 0 0 6px; font-size: 1.3rem; }
        .empty p { margin: 0 0 20px; color: var(--muted); }

        /* ---------- Forms ---------- */
        .panel {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 28px;
        }
        .field { margin-bottom: 22px; }
        .field label {
            display: block;
            font-family: var(--ui);
            font-weight: 500;
            margin-bottom: 6px;
        }
        .field input,
        .field textarea {
            width: 100%;
            font: inherit;
            padding: 12px 14px;
            border: 1px solid #b9c2d4;
            border-radius: 8px;
            background: #fff;
            color: var(--ink);
        }
        .field textarea { min-height: 220px; resize: vertical; }
        .field input:focus,
        .field textarea:focus {
            outline: 3px solid rgba(15, 118, 110, 0.35);
            border-color: var(--accent);
        }
        .field.has-error input,
        .field.has-error textarea { border-color: var(--danger); background: var(--danger-bg); }
        .error-text {
            font-family: var(--ui);
            color: var(--danger);
            font-size: 0.9rem;
            margin: 6px 0 0;
        }
        .form-actions { display: flex; gap: 12px; flex-wrap: wrap; }

        /* ---------- Single post ---------- */
        .article h1 {
            font-family: var(--ui);
            font-size: clamp(2rem, 6vw, 3rem);
            line-height: 1.12;
            letter-spacing: -0.02em;
            margin: 0 0 10px;
        }
        .article .byline {
            font-family: var(--ui);
            color: var(--muted);
            font-size: 0.95rem;
            margin-bottom: 32px;
        }
        .article .content {
            white-space: pre-line;
            max-width: 68ch;
            font-size: 1.15rem;
            line-height: 1.8;
        }
        .article-foot {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid var(--line);
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        @media (max-width: 520px) {
            .panel { padding: 20px; }
            .page { padding-top: 28px; }
        }

        @media (prefers-reduced-motion: no-preference) {
            .btn, .post-title { transition: background-color .15s, color .15s; }
        }
    </style>
     @stack('styles')
</head>
<body>
    <header class="topbar">
        <div class="topbar-inner">
            <a class="brand" href="{{ route('posts.index') }}">Sularte Blog</a>
            <a class="btn" href="{{ route('posts.create') }}">New post</a>
        </div>
    </header>

    <main class="page">
        @if(session('success'))
            <div class="flash" role="status">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>