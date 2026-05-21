@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Eksekusi SPK Profile Matching</h1>
    <p class="text-slate-500 dark:text-slate-400 mt-2 transition-colors duration-300">Proses algoritma pencocokan profil untuk menentukan rekomendasi rotasi jabatan yang paling optimal.</p>
</div>

@if (session('error'))
<div class="bg-red-50 dark:bg-red-500/10 border-l-4 border-red-500 p-4 mb-8 rounded-r-2xl">
    <div class="flex items-start">
        <div class="flex-shrink-0 mt-0.5">
            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-bold text-red-800 dark:text-red-200">Terjadi Kesalahan</h3>
            <p class="text-sm mt-1 text-red-700 dark:text-red-300">{{ session('error') }}</p>
        </div>
    </div>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Status Data -->
    <div class="lg:col-span-2 bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 shadow-sm p-8 transition-all duration-300">
        <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            Kesiapan Data
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-slate-50 dark:bg-slate-700/30 p-6 rounded-2xl border border-slate-100 dark:border-slate-600/50">
                <div class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Total Kandidat (Pegawai)</div>
                <div class="text-3xl font-extrabold text-slate-800 dark:text-white">{{ $pegawais->count() }} <span class="text-base font-normal text-slate-500">Orang</span></div>
            </div>
            
            <div class="bg-slate-50 dark:bg-slate-700/30 p-6 rounded-2xl border border-slate-100 dark:border-slate-600/50">
                <div class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Status Penilaian</div>
                @if($dataBelumLengkap > 0)
                    <div class="text-3xl font-extrabold text-red-600 dark:text-red-400">{{ $dataBelumLengkap }} <span class="text-base font-normal text-red-500/80">Belum Dinilai</span></div>
                    <p class="text-xs text-red-500 mt-2">Peringatan: Pastikan semua data arsip & observasi telah diisi agar hasil akurat.</p>
                @else
                    <div class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400">100% <span class="text-base font-normal text-emerald-500/80">Lengkap</span></div>
                    <p class="text-xs text-emerald-500 mt-2">Semua data kandidat siap untuk diproses.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Action Panel -->
    <div class="bg-indigo-600 dark:bg-indigo-700 rounded-[2rem] shadow-xl shadow-indigo-200 dark:shadow-indigo-900/50 p-8 text-white flex flex-col justify-between relative overflow-hidden group">
        <!-- Abstract Decoration -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all duration-500"></div>
        
        <div class="relative z-10">
            <h2 class="text-xl font-bold mb-2">Mulai Perhitungan</h2>
            <p class="text-indigo-100 text-sm mb-6 leading-relaxed">
                Sistem akan membandingkan nilai riil (arsip & observasi) dengan nilai target jabatan (Target Profil) lalu mengkalkulasikan NCF dan NSF.
            </p>
        </div>

        <div class="relative z-10">
            <form action="{{ route('spk.hitung') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-white text-indigo-600 hover:bg-indigo-50 font-bold py-4 px-6 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                    </svg>
                    Hitung SPK Sekarang
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Daftar Pegawai Preview -->
<div class="bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 shadow-sm overflow-hidden transition-all duration-300">
    <div class="p-6 border-b border-slate-100 dark:border-slate-700/50">
        <h3 class="font-bold text-slate-800 dark:text-white text-lg">Daftar Kandidat Rotasi</h3>
    </div>
    <div class="overflow-x-auto p-4">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                    <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50 first:rounded-l-xl">NIP</th>
                    <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50">Nama Pegawai</th>
                    <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50">Jabatan Saat Ini</th>
                    <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50 text-center last:rounded-r-xl">Status Penilaian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawais as $pegawai)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                    <td class="py-3 px-4 border-b border-slate-100 dark:border-slate-700/50 text-slate-700 dark:text-slate-300 text-sm">{{ $pegawai->nip }}</td>
                    <td class="py-3 px-4 border-b border-slate-100 dark:border-slate-700/50 font-semibold text-slate-800 dark:text-slate-200 text-sm">{{ $pegawai->nama }}</td>
                    <td class="py-3 px-4 border-b border-slate-100 dark:border-slate-700/50 text-slate-600 dark:text-slate-400 text-sm">{{ $pegawai->jabatan->nama_jabatan ?? '-' }}</td>
                    <td class="py-3 px-4 border-b border-slate-100 dark:border-slate-700/50 text-center">
                        @if($pegawai->arsip && $pegawai->observasi)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400">Siap</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400">Belum Lengkap</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
