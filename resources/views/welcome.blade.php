<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Rotasi - Kejaksaan Negeri Banjarmasin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.6;
            animation: move 10s infinite alternate;
        }
        @keyframes move {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(20px, -20px) scale(1.1); }
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen overflow-hidden flex flex-col">

    <!-- Background Blobs -->
    <div class="blob bg-indigo-300 w-96 h-96 rounded-full top-10 left-10"></div>
    <div class="blob bg-emerald-200 w-80 h-80 rounded-full bottom-20 right-20" style="animation-delay: -5s;"></div>
    <div class="blob bg-blue-300 w-72 h-72 rounded-full top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>

    <!-- Navigation -->
    <nav class="w-full px-8 py-6 flex justify-between items-center relative z-10">
        <div class="flex items-center gap-3">
            <img src="{{ asset('img/logo.png') }}" alt="Logo Kejari" class="w-10 h-10 object-contain drop-shadow-md">
            <span class="font-bold text-xl tracking-tight text-slate-800">Kejari Banjarmasin</span>
        </div>
        <div>
            @auth
                <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-white text-indigo-600 font-semibold rounded-full shadow-sm hover:shadow-md transition-all">Go to Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-6 py-2.5 bg-slate-800 text-white font-semibold rounded-full shadow-md hover:bg-slate-700 hover:shadow-lg transition-all transform hover:-translate-y-0.5">Masuk Sistem</a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-grow flex items-center justify-center relative z-10 px-6">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 font-medium text-sm mb-8 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                Sistem Pendukung Keputusan Berbasis Web
            </div>
            
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-slate-900 mb-6 leading-tight">
                Rotasi Jabatan <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-emerald-500">Lebih Objektif & Tepat</span>
            </h1>
            
            <p class="text-lg md:text-xl text-slate-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                Platform cerdas menggunakan metode <strong class="text-slate-800">Profile Matching</strong> untuk membantu Kejaksaan Negeri Banjarmasin menempatkan kandidat terbaik pada posisi yang tepat berdasarkan kompetensi dan penilaian riil.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-2xl shadow-xl shadow-indigo-200 transition-all transform hover:scale-105 active:scale-95 flex items-center justify-center gap-2 text-lg">
                    Mulai Sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#features" class="w-full sm:w-auto px-8 py-4 bg-white/80 backdrop-blur border border-slate-200 text-slate-700 font-semibold rounded-2xl hover:bg-slate-50 transition-all flex items-center justify-center text-lg">
                    Pelajari Fitur
                </a>
            </div>
        </div>
    </main>

    <!-- Decorative Bottom UI (Optional Dashboard Mockup) -->
    <div class="relative z-10 w-full max-w-5xl mx-auto h-64 -mb-32 hidden md:block">
        <div class="glass-panel w-full h-full rounded-t-[2rem] shadow-2xl p-6 flex gap-6 overflow-hidden">
            <div class="w-64 h-full bg-white/50 rounded-xl border border-white/60 p-4">
                <div class="w-full h-8 bg-slate-200/50 rounded-lg mb-4"></div>
                <div class="w-3/4 h-4 bg-slate-200/50 rounded mb-2"></div>
                <div class="w-1/2 h-4 bg-slate-200/50 rounded mb-6"></div>
                <div class="w-full h-10 bg-indigo-100/50 rounded-lg mb-2"></div>
                <div class="w-full h-10 bg-slate-100/50 rounded-lg"></div>
            </div>
            <div class="flex-grow flex flex-col gap-6">
                <div class="flex gap-4">
                    <div class="flex-1 h-24 bg-white/60 rounded-2xl border border-white/60 p-4"></div>
                    <div class="flex-1 h-24 bg-white/60 rounded-2xl border border-white/60 p-4"></div>
                    <div class="flex-1 h-24 bg-white/60 rounded-2xl border border-white/60 p-4"></div>
                </div>
                <div class="flex-grow bg-white/60 rounded-2xl border border-white/60"></div>
            </div>
        </div>
    </div>

</body>
</html>
