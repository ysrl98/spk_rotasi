<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPK Rotasi Jabatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 30px 30px;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="bg-pattern min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-100/50 to-transparent -z-10"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-indigo-400/20 rounded-full blur-3xl -z-10"></div>
    <div class="absolute top-20 -left-20 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl -z-10"></div>

    <div class="w-full max-w-5xl flex rounded-[2.5rem] shadow-2xl shadow-slate-200/50 overflow-hidden bg-white/40 backdrop-blur-sm border border-white/60">
        
        <!-- Left Side: Branding/Image -->
        <div class="hidden lg:flex w-1/2 bg-indigo-600 p-12 flex-col justify-between relative overflow-hidden text-white">
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&q=80')] bg-cover bg-center opacity-20 mix-blend-overlay"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/80 to-transparent"></div>
            
            <div class="relative z-10 flex items-center gap-3">
                <div class="w-14 h-14 bg-white/90 backdrop-blur rounded-2xl flex items-center justify-center shadow-lg p-2">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo Kejari" class="w-full h-full object-contain">
                </div>
                <span class="font-bold text-3xl tracking-tight">Kejari</span>
            </div>

            <div class="relative z-10 mt-20">
                <div class="inline-flex px-3 py-1 rounded-full bg-indigo-500/30 border border-indigo-400/30 text-indigo-100 text-sm font-medium mb-6 backdrop-blur-md">
                    SPK Profile Matching
                </div>
                <h1 class="text-4xl font-bold leading-tight mb-4">Rotasi Jabatan<br>Berbasis Kinerja.</h1>
                <p class="text-indigo-100/80 text-lg leading-relaxed max-w-sm">
                    Tingkatkan efisiensi penempatan pegawai melalui analisis kompetensi yang objektif dan transparan.
                </p>
            </div>

            <!-- Avatar/Testimonial decoration -->
            <div class="relative z-10 flex -space-x-4 mt-12">
                <img class="w-10 h-10 rounded-full border-2 border-indigo-600" src="https://ui-avatars.com/api/?name=Admin&background=random" alt="Admin">
                <img class="w-10 h-10 rounded-full border-2 border-indigo-600" src="https://ui-avatars.com/api/?name=Kajari&background=random" alt="Kajari">
                <div class="w-10 h-10 rounded-full border-2 border-indigo-600 bg-indigo-500 flex items-center justify-center text-xs font-medium">+12</div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 p-8 sm:p-12 lg:p-16 flex flex-col justify-center glass-card relative z-10">
            <div class="mb-10 text-center lg:text-left">
                <h2 class="text-3xl font-bold text-slate-800 mb-2">Selamat Datang 👋</h2>
                <p class="text-slate-500">Silakan masuk ke akun Anda untuk melanjutkan.</p>
            </div>

            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm text-red-700 font-medium">{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="username" class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" 
                            class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all shadow-sm" 
                            placeholder="Masukkan username Anda" required autofocus>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                        <!-- Optional Forgot Password Link -->
                        <!-- <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Lupa sandi?</a> -->
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" 
                            class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all shadow-sm" 
                            placeholder="••••••••" required>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded cursor-pointer transition-colors">
                    <label for="remember" class="ml-2 block text-sm text-slate-600 cursor-pointer">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-200 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02] active:scale-95">
                    Masuk Sekarang
                </button>
            </form>
            
            <p class="mt-8 text-center text-sm text-slate-500">
                Sistem internal <span class="font-semibold text-slate-700">Kejaksaan Negeri Banjarmasin</span>.
            </p>
        </div>
    </div>

</body>
</html>