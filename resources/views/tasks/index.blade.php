<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Tugas | Evolusi PL</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen font-sans antialiased selection:bg-indigo-500 selection:text-white relative overflow-x-hidden">
    {{-- Background glows --}}
    <div class="fixed inset-0 -z-10 flex items-center justify-center">
        <div class="w-[600px] h-[600px] bg-indigo-600/15 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="w-[450px] h-[450px] bg-sky-500/10 rounded-full blur-[120px] pointer-events-none -translate-y-24 translate-x-32"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex flex-col min-h-screen">
        {{-- Header --}}
        <header class="flex items-center justify-between border-b border-slate-800 pb-6 mb-8">
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-500 to-sky-500 flex items-center justify-center shadow-lg shadow-indigo-500/25 hover:opacity-90 transition">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="font-bold text-xl leading-tight text-white">Daftar Tugas Praktikum</h1>
                    <p class="text-xs text-slate-400">Modul CRUD Laravel - NIM 24/544540/SV/25445</p>
                </div>
            </div>
            <a href="{{ url('/') }}" class="text-xs font-medium text-slate-300 hover:text-white px-3.5 py-1.5 rounded-lg bg-slate-900 border border-slate-700 hover:border-slate-600 transition">
                &larr; Kembali ke Beranda
            </a>
        </header>

        {{-- Flash message --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Form Tambah Tugas --}}
        <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6 mb-8 backdrop-blur-sm">
            <h2 class="text-base font-semibold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Tugas Baru
            </h2>
            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="title" class="block text-xs font-medium text-slate-300 mb-1">Judul Tugas <span class="text-rose-400">*</span></label>
                    <input type="text" name="title" id="title" required placeholder="Contoh: Menyiapkan pipeline CI/CD..."
                        class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition">
                    @error('title')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="description" class="block text-xs font-medium text-slate-300 mb-1">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="2" placeholder="Catatan atau rincian pengerjaan..."
                        class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-medium rounded-xl transition shadow-lg shadow-indigo-600/20">
                        Simpan Tugas
                    </button>
                </div>
            </form>
        </div>

        {{-- Daftar Tugas --}}
        <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6 backdrop-blur-sm flex-1">
            <h2 class="text-base font-semibold text-white mb-4">Daftar Tugas Aktif ({{ $tasks->count() }})</h2>
            @if ($tasks->isEmpty())
                <div class="text-center py-12 text-slate-500">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-sm">Belum ada tugas. Tambahkan tugas pertama melalui formulir di atas.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($tasks as $task)
                        <div class="flex items-center justify-between p-4 rounded-xl border {{ $task->is_completed ? 'bg-slate-950/40 border-slate-900 opacity-60' : 'bg-slate-950 border-slate-800' }} transition">
                            <div class="flex items-start gap-3 flex-1 min-w-0 pr-4">
                                <form action="{{ route('tasks.update', $task) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="mt-0.5 w-5 h-5 rounded border flex items-center justify-center transition {{ $task->is_completed ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-700 hover:border-indigo-500' }}">
                                        @if ($task->is_completed)
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                            </svg>
                                        @endif
                                    </button>
                                </form>
                                <div class="min-w-0">
                                    <h3 class="text-sm font-medium {{ $task->is_completed ? 'line-through text-slate-500' : 'text-slate-100' }}">
                                        {{ $task->title }}
                                    </h3>
                                    @if ($task->description)
                                        <p class="text-xs text-slate-400 mt-0.5 line-clamp-2">{{ $task->description }}</p>
                                    @endif
                                    <span class="text-[10px] text-slate-500 mt-1 inline-block">Dibuat: {{ $task->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Hapus tugas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-500 hover:text-rose-400 p-2 rounded-lg hover:bg-slate-900 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</body>
</html>
