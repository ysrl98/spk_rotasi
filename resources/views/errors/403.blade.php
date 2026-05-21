@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[60vh] text-center px-4 animate-in">
    
    <!-- Ikon Gembok Berkaca (Glassmorphism) -->
    <div class="relative mb-8 group">
        <div class="absolute inset-0 bg-red-400/20 dark:bg-red-500/20 rounded-full blur-2xl group-hover:bg-red-500/30 transition-all duration-500"></div>
        <div class="w-32 h-32 bg-white/50 dark:bg-slate-800/50 backdrop-blur-xl border border-white/60 dark:border-slate-700/50 rounded-[2.5rem] shadow-2xl flex items-center justify-center relative z-10 transform rotate-3 group-hover:rotate-0 transition-transform duration-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-500 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        
        <!-- Ornamen Peringatan -->
        <div class="absolute -top-2 -right-2 w-10 h-10 bg-red-100 dark:bg-red-500/20 rounded-full flex items-center justify-center border-2 border-white dark:border-slate-800 z-20 shadow-sm animate-bounce">
            <span class="text-red-600 dark:text-red-400 font-bold text-xl">!</span>
        </div>
    </div>

    <!-- Teks Pemberitahuan -->
    <h1 class="text-4xl md:text-5xl font-extrabold text-slate-800 dark:text-white mb-4 tracking-tight">Akses Ditolak</h1>
    
    <p class="text-lg text-slate-500 dark:text-slate-400 max-w-lg mb-10 leading-relaxed">
        Maaf, Anda tidak memiliki izin (hak akses) untuk melihat halaman ini. Halaman ini hanya diperuntukkan bagi level pengguna tertentu.
    </p>

    <!-- Tombol Navigasi -->
    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('dashboard') }}" class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-semibold shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 transition-all transform hover:scale-105 active:scale-95 flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
        <a href="{{ route('dashboard') }}" class="px-8 py-3.5 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600/50 rounded-2xl font-semibold shadow-sm transition-all flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Ke Dashboard
        </a>
    </div>
</div>
@endsection