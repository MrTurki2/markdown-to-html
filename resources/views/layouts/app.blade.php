<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Markdown to HTML Converter')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap');

        body {
            font-family: 'Cairo', sans-serif;
        }

        .markdown-output {
            line-height: 1.8;
        }

        .markdown-output h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #1a202c;
        }

        .markdown-output h2 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.75rem;
            color: #2d3748;
        }

        .markdown-output h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #4a5568;
        }

        .markdown-output p {
            margin-bottom: 1rem;
            color: #4a5568;
        }

        .markdown-output ul, .markdown-output ol {
            margin-right: 2rem;
            margin-bottom: 1rem;
        }

        .markdown-output li {
            margin-bottom: 0.5rem;
        }

        .markdown-output code {
            background-color: #f7fafc;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-family: monospace;
            font-size: 0.9em;
        }

        .markdown-output pre {
            background-color: #2d3748;
            color: #e2e8f0;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin-bottom: 1rem;
        }

        .markdown-output pre code {
            background: transparent;
            padding: 0;
            color: inherit;
        }

        .markdown-output blockquote {
            border-right: 4px solid #4299e1;
            padding-right: 1rem;
            margin-bottom: 1rem;
            color: #718096;
            font-style: italic;
        }

        .markdown-output a {
            color: #4299e1;
            text-decoration: underline;
        }

        .markdown-output table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .markdown-output th,
        .markdown-output td {
            border: 1px solid #e2e8f0;
            padding: 0.75rem;
            text-align: right;
        }

        .markdown-output th {
            background-color: #f7fafc;
            font-weight: 600;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-reverse space-x-8">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-gray-900">
                        Markdown → HTML
                    </a>
                    <a href="{{ route('lab.index') }}" class="text-gray-600 hover:text-gray-900 transition">
                        🧪 المختبر
                    </a>
                </div>

                <div class="flex items-center">
                    <a href="https://github.com/MrTurki2/markdown-to-html" target="_blank" class="text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-600 text-sm">
                Built with ❤️ using Laravel & Marked.js |
                <a href="https://github.com/MrTurki2/markdown-to-html" class="text-blue-500 hover:underline">View on GitHub</a>
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
