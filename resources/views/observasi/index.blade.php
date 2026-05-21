@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Data Penilaian Observasi</h1>
    <p class="text-slate-500 dark:text-slate-400 mt-2 transition-colors duration-300">Kelola input nilai subjektif (Inisiatif & Kerjasama) untuk masing-masing pegawai.</p>
</div>

@if (session('success'))
<div class="bg-emerald-50 dark:bg-emerald-500/10 border-l-4 border-emerald-500 p-4 mb-8 rounded-r-2xl">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

<div class="bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 shadow-sm overflow-hidden transition-all duration-300">
    <div class="overflow-x-auto p-4">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                    <th class="py-4 px-6 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50 first:rounded-l-xl">NIP</th>
                    <th class="py-4 px-6 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50">Nama Pegawai</th>
                    <th class="py-4 px-6 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50">Inisiatif</th>
                    <th class="py-4 px-6 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50">Kerjasama</th>
                    <th class="py-4 px-6 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50 text-center">Status</th>
                    <th class="py-4 px-6 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50 last:rounded-r-xl text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawais as $pegawai)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors group">
                    <td class="py-4 px-6 border-b border-slate-100 dark:border-slate-700/50 text-slate-700 dark:text-slate-300 font-medium">
                        {{ $pegawai->nip }}
                    </td>
                    <td class="py-4 px-6 border-b border-slate-100 dark:border-slate-700/50 text-slate-800 dark:text-slate-200 font-bold">
                        {{ $pegawai->nama }}
                    </td>
                    <td class="py-4 px-6 border-b border-slate-100 dark:border-slate-700/50 text-slate-600 dark:text-slate-400">
                        {{ $pegawai->observasi->nilai_inisiatif ?? '-' }}
                    </td>
                    <td class="py-4 px-6 border-b border-slate-100 dark:border-slate-700/50 text-slate-600 dark:text-slate-400">
                        {{ $pegawai->observasi->nilai_kerjasama ?? '-' }}
                    </td>
                    <td class="py-4 px-6 border-b border-slate-100 dark:border-slate-700/50 text-center">
                        @if($pegawai->observasi)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400">
                                Lengkap
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400">
                                Kosong
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-6 border-b border-slate-100 dark:border-slate-700/50 text-center">
                        <a href="{{ route('observasi.edit', $pegawai->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-600 dark:hover:text-white rounded-lg transition-all duration-300 font-medium text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            {{ $pegawai->observasi ? 'Edit' : 'Nilai' }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
