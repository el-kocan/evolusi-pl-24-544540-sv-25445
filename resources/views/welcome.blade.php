<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Evolusi PL | 24/544540/SV/25445</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen font-sans antialiased selection:bg-indigo-500 selection:text-white relative overflow-x-hidden">
    {{-- Glow background effects --}}
    <div class="fixed inset-0 -z-10 flex items-center justify-center">
        <div class="w-[600px] h-[600px] bg-indigo-600/15 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="w-[450px] h-[450px] bg-sky-500/10 rounded-full blur-[120px] pointer-events-none -translate-y-24 translate-x-32"></div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex flex-col min-h-screen">
        {{-- Navbar --}}
        <header class="flex items-center justify-between border-b border-slate-800/80 pb-6 mb-12">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-500 to-sky-500 flex items-center justify-center shadow-lg shadow-indigo-500/25">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-tight text-white">Evolusi PL v2</h1>
                    <p class="text-xs text-slate-400">Universitas Gadjah Mada</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    CI / CD Ready
                </span>
                <a href="{{ route('tasks.index') }}" class="text-xs font-medium text-white px-3.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 transition shadow-lg shadow-indigo-600/20">
                    Kelola Tugas (CRUD) &rarr;
                </a>
                <a href="https://github.com/el-kocan/evolusi-pl-24-544540-sv-25445" target="_blank" class="text-xs font-medium text-slate-300 hover:text-white px-3.5 py-1.5 rounded-lg bg-slate-900 border border-slate-700 hover:border-slate-600 transition">
                    GitHub Repo &rarr;
                </a>
            </div>
        </header>

        {{-- Hero Section --}}
        <main class="flex-1 flex flex-col justify-center">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 mb-6">
                    <span>Praktikum 02</span>
                    <span class="text-slate-500">•</span>
                    <span>Manajemen GitHub & Prinsip CI</span>
                </div>
                <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-white mb-6">
                    Aplikasi Web Terintegrasi <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 via-sky-300 to-emerald-400">Continuous Integration</span>
                </h2>
                <p class="text-base sm:text-lg text-slate-300 leading-relaxed">
                    Repository ini dikembangkan dengan kaidah <span class="text-indigo-300 font-medium">Conventional Commits</span>, alur branching terproteksi (<code class="text-xs bg-slate-800 px-2 py-0.5 rounded text-sky-300">main &larr; dev &larr; feature</code>), serta pipeline pengujian otomatis menggunakan GitHub Actions.
                </p>
            </div>

            {{-- Info Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                {{-- Card 1: Identitas --}}
                <div class="bg-slate-900/60 border border-slate-800 backdrop-blur-sm rounded-2xl p-6 hover:border-slate-700 transition">
                    <div class="w-10 h-10 rounded-lg bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Identitas Praktikan</h3>
                    <div class="space-y-1.5 text-sm text-slate-400">
                        <p><span class="text-slate-500">NIM:</span> <span class="font-mono text-slate-200">24/544540/SV/25445</span></p>
                        <p><span class="text-slate-500">Mata Kuliah:</span> Konstruksi & Evolusi PL</p>
                        <p><span class="text-slate-500">Instansi:</span> Universitas Gadjah Mada</p>
                    </div>
                </div>

                {{-- Card 2: Git Flow --}}
                <div class="bg-slate-900/60 border border-slate-800 backdrop-blur-sm rounded-2xl p-6 hover:border-slate-700 transition">
                    <div class="w-10 h-10 rounded-lg bg-sky-500/10 border border-sky-500/20 text-sky-400 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Alur Percabangan (Git Flow)</h3>
                    <p class="text-sm text-slate-400 mb-3">
                        Implementasi branching model profesional dengan Branch Protection Rule aktif di <code class="text-xs bg-slate-800 px-1.5 py-0.5 rounded text-sky-300">main</code> dan <code class="text-xs bg-slate-800 px-1.5 py-0.5 rounded text-sky-300">dev</code>.
                    </p>
                    <div class="flex items-center gap-2 text-xs font-mono text-slate-400">
                        <span class="px-2 py-0.5 bg-slate-800 rounded text-indigo-300">feature</span>
                        <span>&rarr;</span>
                        <span class="px-2 py-0.5 bg-slate-800 rounded text-sky-300">dev</span>
                        <span>&rarr;</span>
                        <span class="px-2 py-0.5 bg-slate-800 rounded text-emerald-300">main</span>
                    </div>
                </div>

                {{-- Card 3: CI Pipeline --}}
                <div class="bg-slate-900/60 border border-slate-800 backdrop-blur-sm rounded-2xl p-6 hover:border-slate-700 transition">
                    <div class="w-10 h-10 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Triple-Job Pipeline</h3>
                    <p class="text-sm text-slate-400 mb-3">
                        GitHub Actions otomatis menguji kode pada setiap push & Pull Request.
                    </p>
                    <ul class="space-y-1.5 text-xs text-slate-400 font-mono">
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-400">&check;</span> Job 1: Code Quality & Lint (Pint)
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-400">&check;</span> Job 2: Backend PHPUnit Tests
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-400">&check;</span> Job 3: Frontend Vite Asset Build
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Tech Stack Badges --}}
            <div class="flex flex-wrap items-center justify-center gap-3 text-xs text-slate-400">
                <span class="px-3 py-1 bg-slate-900/90 rounded-lg border border-slate-800">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }}
                </span>
                <span class="px-3 py-1 bg-slate-900/90 rounded-lg border border-slate-800">
                    PHP v{{ PHP_VERSION }}
                </span>
                <span class="px-3 py-1 bg-slate-900/90 rounded-lg border border-slate-800">
                    Vite v{{ json_decode(file_get_contents(base_path('package.json')), true)['devDependencies']['vite'] ?? '8.x' }}
                </span>
                <span class="px-3 py-1 bg-slate-900/90 rounded-lg border border-slate-800">
                    TailwindCSS v4
                </span>
            </div>
        </main>

        {{-- Footer --}}
        <footer class="border-t border-slate-800/80 pt-6 mt-12 text-center text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} Evolusi Perangkat Lunak - SV UGM. Dikelola dengan Git & GitHub Actions CI.</p>
        </footer>
    </div>
</body>
</html>
