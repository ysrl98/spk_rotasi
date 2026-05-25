<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem SPK Kejaksaan</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Memeriksa dan mengatur tema dari local storage saat pertama kali dimuat
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Animasi muncul halus */
        .animate-in { 
            animation: fadeIn 0.5s ease-out forwards; 
        }
        @keyframes fadeIn { 
            from { opacity: 0; transform: translateY(10px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        
        /* Custom scrollbar untuk dashboard */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #475569; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; }

        /* Animasi Blob Background */
        .animate-blob {
            animation: blob 7s infinite alternate;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }

        /* Animasi Toast */
        .toast-enter {
            animation: toastSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .toast-exit {
            animation: toastSlideOut 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes toastSlideIn {
            from { transform: translateX(100%) translateY(0); opacity: 0; }
            to { transform: translateX(0) translateY(0); opacity: 1; }
        }
        @keyframes toastSlideOut {
            from { transform: translateX(0) scale(1); opacity: 1; }
            to { transform: translateX(50%) scale(0.9); opacity: 0; }
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 flex h-screen overflow-hidden relative text-slate-800 dark:text-slate-100 transition-colors duration-300">
    
    <!-- Floating Toast Container -->
    <div id="toast-container" class="fixed top-6 right-6 z-50 flex flex-col gap-3 w-full max-w-sm pointer-events-none"></div>
    
    <!-- Abstract Mesh Background Decoration -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-indigo-400/20 dark:bg-indigo-600/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob pointer-events-none z-0"></div>
    <div class="absolute top-[20%] right-[-10%] w-96 h-96 bg-cyan-400/20 dark:bg-sky-600/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000 pointer-events-none z-0"></div>
    <div class="absolute bottom-[-20%] left-[20%] w-96 h-96 bg-pink-400/20 dark:bg-fuchsia-600/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000 pointer-events-none z-0"></div>

    <!-- Floating Sidebar Wrapper -->
    <div class="p-6 pr-3 h-full z-10 hidden md:block">
        <aside class="w-[280px] h-full bg-white/70 dark:bg-slate-800/70 backdrop-blur-2xl border border-white/50 dark:border-slate-700/50 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex flex-col shrink-0 overflow-y-auto custom-scrollbar transition-colors duration-300">
            
            <!-- Logo Area -->
            <div class="flex items-center gap-4 mt-8 mb-10 px-8 shrink-0">
                <div class="w-12 h-12 bg-white/50 backdrop-blur rounded-2xl shadow-lg shadow-indigo-100 dark:shadow-indigo-900/20 flex items-center justify-center p-1.5 transition-transform duration-300 hover:scale-105">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo Kejari" class="w-full h-full object-contain">
                </div>
                <div class="flex flex-col">
                    <span class="font-extrabold text-slate-800 dark:text-white text-lg tracking-tight leading-none">SPK Kejaksaan</span>
                    <span class="text-xs text-indigo-500 dark:text-indigo-400 font-semibold mt-1">Profile Matching</span>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="space-y-1.5 flex-grow px-4 shrink-0">
                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-4 px-4">Menu Utama</p>
                
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('dashboard') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <span class="font-semibold text-sm">Dashboard</span>
                </a>

                <a href="{{ route('jabatan.index') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('jabatan.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('jabatan.*') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="font-semibold text-sm">Data Jabatan</span>
                </a>

                @if(Auth::user()->role === 'Admin')
                <a href="{{ route('pegawai.index') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('pegawai.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('pegawai.*') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <span class="font-semibold text-sm">Data Pegawai</span>
                </a>
                @endif

                @if(Auth::user()->role === 'Admin')
                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mt-6 mb-4 px-4">Pengaturan SPK</p>

                <a href="{{ route('kriteria.index') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('kriteria.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('kriteria.*') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <span class="font-semibold text-sm">Data Kriteria</span>
                </a>
                
                <a href="{{ route('target-profil.index') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('target-profil.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('target-profil.*') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <span class="font-semibold text-sm">Target Profil</span>
                </a>

                <a href="{{ route('bobot-gap.index') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('bobot-gap.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('bobot-gap.*') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <span class="font-semibold text-sm">Bobot GAP</span>
                </a>
                @endif

                <!-- SECTION: DATA PENILAIAN -->
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold tracking-wider text-slate-400 uppercase">Input Penilaian</p>
                </div>

                <a href="{{ route('arsip.index') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('arsip.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('arsip.*') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <span class="font-semibold text-sm">Data Arsip (Objektif)</span>
                </a>

                <a href="{{ route('observasi.index') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('observasi.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('observasi.*') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </div>
                    <span class="font-semibold text-sm">Observasi (Subjektif)</span>
                </a>
                <!-- SECTION: MANAJEMEN SPK -->
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold tracking-wider text-slate-400 uppercase">Eksekusi SPK</p>
                </div>

                @if(Auth::user()->role === 'Admin')
                <a href="{{ route('spk.proses') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('spk.proses') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('spk.proses') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <span class="font-semibold text-sm">Proses SPK</span>
                </a>
                @endif

                @if(Auth::user()->role === 'Admin')
                <a href="{{ route('spk.hasil') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('spk.hasil') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->requestUri === '/spk/hasil' ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <span class="font-semibold text-sm">Hasil Rotasi</span>
                </a>
                @endif

                <!-- SECTION: PIMPINAN -->
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold tracking-wider text-slate-400 uppercase">Pimpinan</p>
                </div>

                <a href="{{ route('validasi.index') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('validasi.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200/50 dark:shadow-emerald-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('validasi.*') ? 'text-emerald-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-emerald-600 dark:group-hover:text-emerald-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
                    </div>
                    <span class="font-semibold text-sm">Hasil & Validasi</span>
                </a>
            </nav>

            <div class="p-6 shrink-0 mt-4">
                <div class="bg-indigo-50/50 dark:bg-slate-700/50 rounded-2xl p-4 border border-indigo-100 dark:border-slate-600">
                    <p class="text-xs text-indigo-800 dark:text-indigo-300 font-medium">Sistem v1.0.0 Alpha</p>
                    <p class="text-[10px] text-indigo-600/70 dark:text-indigo-400 mt-1">Kejaksaan Republik Indonesia</p>
                </div>
            </div>
        </aside>
    </div>

    <!-- Main Content Area -->
    <main class="flex-1 h-full flex flex-col overflow-hidden relative z-10">
        
        <!-- Floating Header Topbar -->
        <div class="px-6 pt-6 pb-2 shrink-0 z-20">
            <header class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl border border-white/80 dark:border-slate-700/50 px-6 py-4 rounded-3xl flex items-center justify-between shadow-[0_4px_20px_rgb(0,0,0,0.03)] transition-colors duration-300">
                <div class="flex items-center gap-3">
                    <!-- Hamburger Menu Button for Mobile -->
                    <button id="mobile-menu-toggle" type="button" class="text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none rounded-xl text-sm p-2 transition-colors md:hidden" title="Buka Menu Navigasi">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="p-2 bg-indigo-50 dark:bg-slate-700 text-indigo-600 dark:text-indigo-400 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-slate-500 dark:text-slate-400 text-sm font-semibold tracking-wide hidden sm:inline-block">
                        {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                    </span>
                </div>
                
                <div class="flex items-center gap-5">
                    
                    <!-- Dark Mode Toggle Button -->
                    <button id="theme-toggle" type="button" class="text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none rounded-xl text-sm p-2.5 transition-colors">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    </button>

                    <!-- User Profile Info -->
                    <div class="flex items-center gap-4">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-slate-800 dark:text-white">{{ Auth::user()->name ?? 'Administrator' }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ Auth::user()->role ?? 'Admin' }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-indigo-600 to-indigo-400 flex items-center justify-center text-white font-bold border-[3px] border-white dark:border-slate-800 shadow-md transform hover:rotate-6 transition-transform duration-300 cursor-pointer">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                    
                    <!-- Divider -->
                    <div class="h-8 w-px bg-slate-200 dark:bg-slate-700"></div>
                    
                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 text-slate-500 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-500 p-2 rounded-xl hover:bg-red-50 dark:hover:bg-slate-700 transition-all duration-300 font-medium text-sm group active:scale-95" title="Logout dari Sistem">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </header>
        </div>

        <!-- Scrollable Page Content -->
        <div class="flex-1 px-6 pb-6 pt-4 overflow-y-auto custom-scrollbar animate-in relative z-10">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </div>
    </main>

    <!-- Script for Dark Mode Toggle -->
    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Change the icons inside the button based on previous settings
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {

            // toggle icons inside button
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // if set via local storage previously
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }

            // if NOT set via local storage previously
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
            
    </script>

    <!-- Mobile Sidebar Drawer Overlay -->
    <div id="mobile-sidebar-backdrop" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 transition-opacity duration-300 opacity-0 pointer-events-none md:hidden"></div>
    
    <div id="mobile-sidebar" class="fixed top-0 left-0 w-[290px] h-full p-6 z-50 transition-transform duration-300 transform -translate-x-full md:hidden flex flex-col">
        <aside class="h-full bg-white/95 dark:bg-slate-800/95 backdrop-blur-2xl border border-slate-200/50 dark:border-slate-700/50 rounded-[2.5rem] shadow-2xl flex flex-col shrink-0 overflow-y-auto custom-scrollbar transition-colors duration-300">
            <!-- Close Button & Logo -->
            <div class="flex items-center justify-between mt-8 mb-8 px-8 shrink-0">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-white/50 backdrop-blur rounded-xl shadow flex items-center justify-center p-1.5">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo Kejari" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-slate-800 dark:text-white text-md tracking-tight leading-none">SPK Kejaksaan</span>
                        <span class="text-[10px] text-indigo-500 dark:text-indigo-400 font-semibold mt-0.5">Profile Matching</span>
                    </div>
                </div>
                <button id="mobile-sidebar-close" type="button" class="text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none rounded-xl p-2 transition-colors" title="Tutup Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Navigation -->
            <nav class="space-y-1.5 flex-grow px-4 shrink-0 overflow-y-auto custom-scrollbar">
                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-4 px-4">Menu Utama</p>
                
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('dashboard') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <span class="font-semibold text-sm">Dashboard</span>
                </a>

                <a href="{{ route('jabatan.index') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('jabatan.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('jabatan.*') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="font-semibold text-sm">Data Jabatan</span>
                </a>

                @if(Auth::user()->role === 'Admin')
                <a href="{{ route('pegawai.index') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('pegawai.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('pegawai.*') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <span class="font-semibold text-sm">Data Pegawai</span>
                </a>
                @endif

                @if(Auth::user()->role === 'Admin')
                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mt-6 mb-4 px-4">Pengaturan SPK</p>

                <a href="{{ route('kriteria.index') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('kriteria.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('kriteria.*') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138z"/></svg>
                    </div>
                    <span class="font-semibold text-sm">Data Kriteria</span>
                </a>
                
                <a href="{{ route('target-profil.index') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('target-profil.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('target-profil.*') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <span class="font-semibold text-sm">Target Profil</span>
                </a>

                <a href="{{ route('bobot-gap.index') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('bobot-gap.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('bobot-gap.*') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <span class="font-semibold text-sm">Bobot GAP</span>
                </a>
                @endif

                <!-- SECTION: DATA PENILAIAN -->
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold tracking-wider text-slate-400 uppercase">Input Penilaian</p>
                </div>

                <a href="{{ route('arsip.index') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('arsip.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('arsip.*') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <span class="font-semibold text-sm">Data Arsip (Objektif)</span>
                </a>

                <a href="{{ route('observasi.index') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('observasi.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('observasi.*') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </div>
                    <span class="font-semibold text-sm">Observasi (Subjektif)</span>
                </a>
                <!-- SECTION: MANAJEMEN SPK -->
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold tracking-wider text-slate-400 uppercase">Eksekusi SPK</p>
                </div>

                @if(Auth::user()->role === 'Admin')
                <a href="{{ route('spk.proses') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('spk.proses') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('spk.proses') ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <span class="font-semibold text-sm">Proses SPK</span>
                </a>
                @endif

                @if(Auth::user()->role === 'Admin')
                <a href="{{ route('spk.hasil') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('spk.hasil') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->requestUri === '/spk/hasil' ? 'text-indigo-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <span class="font-semibold text-sm">Hasil Rotasi</span>
                </a>
                @endif

                <!-- SECTION: PIMPINAN -->
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-bold tracking-wider text-slate-400 uppercase">Pimpinan</p>
                </div>

                <a href="{{ route('validasi.index') }}" 
                   class="flex items-center gap-4 py-3.5 px-4 rounded-2xl transition-all duration-300 group {{ request()->routeIs('validasi.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200/50 dark:shadow-emerald-900/50 scale-[1.02]' : 'text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700/50 hover:shadow-sm hover:scale-[1.02] active:scale-95' }}">
                    <div class="{{ request()->routeIs('validasi.*') ? 'text-emerald-100' : 'text-slate-400 dark:text-slate-500 group-hover:text-emerald-600 dark:group-hover:text-emerald-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138z" /></svg>
                    </div>
                    <span class="font-semibold text-sm">Hasil & Validasi</span>
                </a>
            </nav>
            
            <div class="p-6 shrink-0 mt-4">
                <div class="bg-indigo-50/50 dark:bg-slate-700/50 rounded-2xl p-4 border border-indigo-100 dark:border-slate-600">
                    <p class="text-xs text-indigo-800 dark:text-indigo-300 font-medium">Sistem v1.0.0 Alpha</p>
                    <p class="text-[10px] text-indigo-600/70 dark:text-indigo-400 mt-1">Kejaksaan Republik Indonesia</p>
                </div>
            </div>
        </aside>
    </div>

    <!-- Script for Mobile Sidebar Control -->
    <script>
        const mobileMenuToggleBtn = document.getElementById('mobile-menu-toggle');
        const mobileSidebarCloseBtn = document.getElementById('mobile-sidebar-close');
        const mobileSidebarBackdrop = document.getElementById('mobile-sidebar-backdrop');
        const mobileSidebar = document.getElementById('mobile-sidebar');

        function openMobileSidebar() {
            mobileSidebarBackdrop.classList.remove('opacity-0', 'pointer-events-none');
            mobileSidebarBackdrop.classList.add('opacity-100');
            mobileSidebar.classList.remove('-translate-x-full');
        }

        function closeMobileSidebar() {
            mobileSidebarBackdrop.classList.remove('opacity-100');
            mobileSidebarBackdrop.classList.add('opacity-0', 'pointer-events-none');
            mobileSidebar.classList.add('-translate-x-full');
        }

        if (mobileMenuToggleBtn) {
            mobileMenuToggleBtn.addEventListener('click', openMobileSidebar);
        }
        if (mobileSidebarCloseBtn) {
            mobileSidebarCloseBtn.addEventListener('click', closeMobileSidebar);
        }
        if (mobileSidebarBackdrop) {
            mobileSidebarBackdrop.addEventListener('click', closeMobileSidebar);
        }
    </script>

    <!-- Script for Premium Floating Toasts -->
    <script>
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            // Create toast card element
            const toast = document.createElement('div');
            toast.className = `toast-enter flex items-start gap-4 p-4 rounded-2xl shadow-xl backdrop-blur-xl border pointer-events-auto transition-all duration-300 ${
                type === 'success' 
                    ? 'bg-emerald-50/90 dark:bg-emerald-950/90 border-emerald-200/50 dark:border-emerald-800/30 text-emerald-800 dark:text-emerald-200 shadow-emerald-100/10 dark:shadow-emerald-950/20' 
                    : 'bg-rose-50/90 dark:bg-rose-950/90 border-rose-200/50 dark:border-rose-800/30 text-rose-800 dark:text-rose-200 shadow-rose-100/10 dark:shadow-rose-950/20'
            }`;

            // Define icons based on type
            const icon = type === 'success' 
                ? `<div class="p-1 bg-emerald-500 text-white rounded-lg shadow-md shadow-emerald-200 dark:shadow-none shrink-0">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                           <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                       </svg>
                   </div>`
                : `<div class="p-1 bg-rose-500 text-white rounded-lg shadow-md shadow-rose-200 dark:shadow-none shrink-0">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                           <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                       </svg>
                   </div>`;

            toast.innerHTML = `
                ${icon}
                <div class="flex-1">
                    <p class="text-sm font-bold leading-tight">${type === 'success' ? 'Berhasil' : 'Terjadi Kesalahan'}</p>
                    <p class="text-xs font-semibold mt-1 opacity-90">${message}</p>
                </div>
                <button type="button" class="text-current opacity-50 hover:opacity-100 transition-opacity p-0.5 shrink-0" onclick="this.parentElement.remove()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;

            // Append to container
            container.appendChild(toast);

            // Auto dismiss after 4 seconds
            setTimeout(() => {
                toast.classList.remove('toast-enter');
                toast.classList.add('toast-exit');
                // Remove from DOM after exit animation ends
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 4000);
        };
    </script>

    <!-- Trigger Toasts from Laravel Sessions -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.showToast("{{ session('success') }}", 'success');
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.showToast("{{ session('error') }}", 'error');
            });
        </script>
    @endif
</body>
</html>