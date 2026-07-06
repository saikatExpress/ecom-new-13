<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $appName }} — API</title>
    <link rel="icon" href="{{ asset('icon/favicon.jpg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|jetbrains-mono:400,500" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #0a0e17;
            --surface: #111827;
            --surface-2: #1a2234;
            --border: #243049;
            --text: #e8edf7;
            --muted: #8b9ab8;
            --accent: #6366f1;
            --accent-glow: rgba(99, 102, 241, 0.35);
            --success: #34d399;
            --warning: #fbbf24;
            --danger: #f87171;
            --mono: 'JetBrains Mono', ui-monospace, monospace;
            --sans: 'Instrument Sans', system-ui, sans-serif;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--sans);
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            min-height: 100vh;
        }

        .bg-grid {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(99, 102, 241, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99, 102, 241, 0.04) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: radial-gradient(ellipse 80% 60% at 50% 0%, black 20%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .glow {
            position: fixed;
            top: -120px;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 400px;
            background: radial-gradient(circle, var(--accent-glow) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 1080px;
            margin: 0 auto;
            padding: 3rem 1.5rem 4rem;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 3.5rem;
        }

        .logo-mark {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--accent), #818cf8);
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 1.1rem;
            color: white;
            box-shadow: 0 8px 24px var(--accent-glow);
        }

        .env-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            border: 1px solid var(--border);
            background: var(--surface);
        }

        .env-badge .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--success);
            box-shadow: 0 0 8px var(--success);
        }

        .env-badge.production .dot { background: var(--accent); box-shadow: 0 0 8px var(--accent); }
        .env-badge.staging .dot { background: var(--warning); box-shadow: 0 0 8px var(--warning); }

        .hero { margin-bottom: 3rem; }

        .hero-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-family: var(--mono);
            font-size: 0.8rem;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .hero-label svg { opacity: 0.9; }

        h1 {
            font-size: clamp(2.2rem, 5vw, 3.4rem);
            font-weight: 700;
            letter-spacing: -0.03em;
            line-height: 1.1;
            margin-bottom: 1rem;
        }

        h1 span {
            background: linear-gradient(135deg, #fff 30%, #a5b4fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            max-width: 560px;
            color: var(--muted);
            font-size: 1.05rem;
            margin-bottom: 1.75rem;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 1.15rem;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.15s, box-shadow 0.15s, background 0.15s;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
            box-shadow: 0 4px 20px var(--accent-glow);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 28px var(--accent-glow);
        }

        .btn-ghost {
            background: var(--surface);
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-ghost:hover { background: var(--surface-2); }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.35rem 1.5rem;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin-bottom: 1.1rem;
        }

        .card-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--surface-2);
            display: grid;
            place-items: center;
            color: var(--accent);
        }

        .card h2 {
            font-size: 0.95rem;
            font-weight: 600;
        }

        .stat-list { list-style: none; }

        .stat-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 0.55rem 0;
            border-bottom: 1px solid rgba(36, 48, 73, 0.6);
            font-size: 0.88rem;
        }

        .stat-list li:last-child { border-bottom: none; }

        .stat-list .label { color: var(--muted); }

        .stat-list .value {
            font-family: var(--mono);
            font-size: 0.82rem;
            text-align: right;
            word-break: break-all;
        }

        .pill {
            display: inline-block;
            padding: 0.15rem 0.55rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            font-family: var(--mono);
        }

        .pill-ok { background: rgba(52, 211, 153, 0.15); color: var(--success); }
        .pill-warn { background: rgba(251, 191, 36, 0.15); color: var(--warning); }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .endpoint-list { display: flex; flex-direction: column; gap: 0.65rem; }

        .endpoint {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.85rem 1rem;
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 0.88rem;
        }

        .method {
            font-family: var(--mono);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            min-width: 52px;
            text-align: center;
        }

        .method-get { background: rgba(52, 211, 153, 0.15); color: var(--success); }
        .method-post { background: rgba(99, 102, 241, 0.15); color: #a5b4fc; }
        .method-soon { background: rgba(139, 154, 184, 0.12); color: var(--muted); }

        .endpoint-path {
            font-family: var(--mono);
            font-size: 0.84rem;
            color: var(--text);
        }

        .endpoint-desc {
            margin-left: auto;
            color: var(--muted);
            font-size: 0.82rem;
            display: none;
        }

        @media (min-width: 640px) {
            .endpoint-desc { display: block; }
        }

        .code-block {
            background: #070b12;
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            margin-top: 1rem;
        }

        .code-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.65rem 1rem;
            background: var(--surface-2);
            border-bottom: 1px solid var(--border);
            font-family: var(--mono);
            font-size: 0.75rem;
            color: var(--muted);
        }

        .code-dots { display: flex; gap: 6px; }

        .code-dots span {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--border);
        }

        .code-dots span:nth-child(1) { background: #f87171; }
        .code-dots span:nth-child(2) { background: #fbbf24; }
        .code-dots span:nth-child(3) { background: #34d399; }

        pre {
            padding: 1.15rem 1.25rem;
            overflow-x: auto;
            font-family: var(--mono);
            font-size: 0.8rem;
            line-height: 1.7;
            color: #c9d5ef;
        }

        .json-key { color: #93c5fd; }
        .json-str { color: #86efac; }
        .json-bool { color: #fbbf24; }

        .packages {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .package-tag {
            font-family: var(--mono);
            font-size: 0.76rem;
            padding: 0.35rem 0.65rem;
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--muted);
        }

        .package-tag strong { color: var(--text); font-weight: 500; }

        footer {
            margin-top: 3rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 0.75rem;
            font-size: 0.82rem;
            color: var(--muted);
        }

        footer a {
            color: var(--accent);
            text-decoration: none;
        }

        footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="glow"></div>

    <div class="container">
        <header>
            <div class="logo-mark">{{ strtoupper(substr($appName, 0, 1)) }}</div>
            <div class="env-badge {{ $environment === 'production' ? 'production' : ($environment === 'staging' ? 'staging' : '') }}">
                <span class="dot"></span>
                {{ $environment }}
            </div>
        </header>

        <section class="hero">
            <div class="hero-label">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 7h16M4 12h10M4 17h16"/>
                </svg>
                REST API Backend
            </div>
            <h1><span>{{ str_replace('_', ' ', $appName) }}</span></h1>
            <p class="hero-desc">
                Headless e-commerce API built with Laravel {{ explode('.', $laravelVersion)[0] }}.
                JSON-first responses, queue-driven jobs, and a scalable foundation for your storefront or mobile apps.
            </p>
            <div class="hero-actions">
                <a href="{{ url('/up') }}" class="btn btn-primary" target="_blank">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    Health Check
                </a>
                <a href="https://laravel.com/docs" class="btn btn-ghost" target="_blank" rel="noopener">
                    Laravel Docs
                </a>
            </div>
        </section>

        <div class="grid">
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
                        </svg>
                    </div>
                    <h2>Application</h2>
                </div>
                <ul class="stat-list">
                    <li><span class="label">Base URL</span><span class="value">{{ $appUrl }}</span></li>
                    <li><span class="label">Locale</span><span class="value">{{ $locale }}</span></li>
                    <li>
                        <span class="label">Debug</span>
                        <span class="value">
                            <span class="pill {{ $debug ? 'pill-warn' : 'pill-ok' }}">{{ $debug ? 'enabled' : 'disabled' }}</span>
                        </span>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
                            <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
                        </svg>
                    </div>
                    <h2>Database</h2>
                </div>
                <ul class="stat-list">
                    <li><span class="label">Driver</span><span class="value">{{ $database['connection'] }}</span></li>
                    <li><span class="label">Database</span><span class="value">{{ $database['name'] }}</span></li>
                    <li><span class="label">Host</span><span class="value">{{ $database['host'] }}</span></li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                        </svg>
                    </div>
                    <h2>Infrastructure</h2>
                </div>
                <ul class="stat-list">
                    <li><span class="label">Cache</span><span class="value">{{ $cache }}</span></li>
                    <li><span class="label">Queue</span><span class="value">{{ $queue }}</span></li>
                    <li><span class="label">Session</span><span class="value">{{ $session }}</span></li>
                    <li><span class="label">Mail</span><span class="value">{{ $mail }}</span></li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>
                        </svg>
                    </div>
                    <h2>Runtime Stack</h2>
                </div>
                <ul class="stat-list">
                    <li><span class="label">PHP</span><span class="value">{{ $phpVersion }}</span></li>
                    <li><span class="label">Laravel</span><span class="value">{{ $laravelVersion }}</span></li>
                </ul>
                <div class="packages">
                    @foreach ($packages as $name => $constraint)
                        <span class="package-tag"><strong>{{ $name }}</strong> {{ $constraint }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom: 1.25rem;">
            <div class="section-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                </svg>
                API Endpoints
            </div>
            <div class="endpoint-list">
                <div class="endpoint">
                    <span class="method method-get">GET</span>
                    <span class="endpoint-path">/up</span>
                    <span class="endpoint-desc">Health &amp; readiness probe</span>
                </div>
                <div class="endpoint">
                    <span class="method method-get">GET</span>
                    <span class="endpoint-path">/api/v1/products</span>
                    <span class="endpoint-desc">Product catalog — coming soon</span>
                </div>
                <div class="endpoint">
                    <span class="method method-get">GET</span>
                    <span class="endpoint-path">/api/v1/categories</span>
                    <span class="endpoint-desc">Category tree — coming soon</span>
                </div>
                <div class="endpoint">
                    <span class="method method-post">POST</span>
                    <span class="endpoint-path">/api/v1/cart</span>
                    <span class="endpoint-desc">Cart operations — coming soon</span>
                </div>
                <div class="endpoint">
                    <span class="method method-post">POST</span>
                    <span class="endpoint-path">/api/v1/orders</span>
                    <span class="endpoint-desc">Checkout &amp; orders — coming soon</span>
                </div>
            </div>

            <div class="code-block">
                <div class="code-header">
                    <div class="code-dots"><span></span><span></span><span></span></div>
                    <span>example response</span>
                </div>
                <pre>{
  <span class="json-key">"app"</span>: <span class="json-str">"{{ $appName }}"</span>,
  <span class="json-key">"version"</span>: <span class="json-str">"v1"</span>,
  <span class="json-key">"environment"</span>: <span class="json-str">"{{ $environment }}"</span>,
  <span class="json-key">"status"</span>: <span class="json-str">"ok"</span>,
  <span class="json-key">"api"</span>: {
    <span class="json-key">"base_url"</span>: <span class="json-str">"{{ rtrim($appUrl, '/') }}/api/v1"</span>,
    <span class="json-key">"accept"</span>: <span class="json-str">"application/json"</span>
  }
}</pre>
            </div>
        </div>

        <footer>
            <span>Built with Laravel {{ $laravelVersion }} &middot; PHP {{ $phpVersion }}</span>
            <span>
                <a href="https://laravel.com/docs/routing#api-routes" target="_blank" rel="noopener">API routing guide</a>
            </span>
        </footer>
    </div>
</body>
</html>
