@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Dashboard</h1>
    <p class="text-slate-500 dark:text-slate-400 mt-2 transition-colors duration-300">Selamat datang, Anda login sebagai <strong>{{ $role ?? 'User' }}</strong>.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card Pegawai -->
    <div class="bg-white dark:bg-slate-800/80 p-6 rounded-3xl border border-slate-100 dark:border-slate-700/50 shadow-sm flex items-center gap-4 hover:shadow-md transition-all duration-300">
        <div class="w-14 h-14 rounded-full bg-indigo-50 dark:bg-indigo-500/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Pegawai</p>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-white">{{ \App\Models\Pegawai::count() }}</h3>
        </div>
    </div>

    <!-- Card Jabatan -->
    <div class="bg-white dark:bg-slate-800/80 p-6 rounded-3xl border border-slate-100 dark:border-slate-700/50 shadow-sm flex items-center gap-4 hover:shadow-md transition-all duration-300">
        <div class="w-14 h-14 rounded-full bg-blue-50 dark:bg-blue-500/20 flex items-center justify-center text-blue-600 dark:text-blue-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Jabatan</p>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-white">{{ \App\Models\Jabatan::count() }}</h3>
        </div>
    </div>

    <!-- Card Kriteria -->
    <div class="bg-white dark:bg-slate-800/80 p-6 rounded-3xl border border-slate-100 dark:border-slate-700/50 shadow-sm flex items-center gap-4 hover:shadow-md transition-all duration-300">
        <div class="w-14 h-14 rounded-full bg-emerald-50 dark:bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
            </svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Kriteria</p>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-white">{{ \App\Models\Kriteria::count() }}</h3>
        </div>
    </div>
</div>

<div class="bg-white dark:bg-slate-800/80 p-8 rounded-3xl border border-slate-100 dark:border-slate-700/50 shadow-sm transition-all duration-300">
    <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-4">Informasi Sistem</h2>
    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
        Sistem Pendukung Keputusan (SPK) Rotasi Pegawai ini menggunakan metode <strong>Profile Matching</strong>. 
        Metode ini membandingkan kompetensi (profil) pegawai dengan kompetensi yang dibutuhkan (profil jabatan), 
        sehingga dapat memberikan rekomendasi rotasi yang paling objektif dan sesuai.
    </p>
</div>
@endsection