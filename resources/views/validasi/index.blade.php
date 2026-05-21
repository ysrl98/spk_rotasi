@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Ringkasan Validasi Rotasi</h1>
    <p class="text-slate-500 dark:text-slate-400 mt-2 transition-colors duration-300">Pilih bidang/jabatan yang kosong untuk melihat dan memvalidasi kandidat yang tersedia.</p>
</div>

@if($grupJabatan->isEmpty())
<div class="bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 p-12 text-center shadow-sm">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-300 dark:text-slate-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
    </svg>
    <h3 class="text-lg font-bold text-slate-700 dark:text-slate-300 mb-1">Data Kosong</h3>
    <p class="text-slate-500 dark:text-slate-400">Belum ada hasil perhitungan SPK yang perlu divalidasi.</p>
</div>
@else

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($grupJabatan as $id_jabatan => $items)
            @php
                $jabatan = $items->first()->jabatan;
                $jumlahKandidat = $items->count();
                $sudahDivalidasi = $items->where('status_validasi', '!=', 'Menunggu')->count();
                $progress = $jumlahKandidat > 0 ? ($sudahDivalidasi / $jumlahKandidat) * 100 : 0;
            @endphp

            <div class="bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col h-full relative">
                
                <!-- Status Validasi Selesai (Jika semua kandidat sudah divalidasi) -->
                @if($sudahDivalidasi === $jumlahKandidat)
                <div class="absolute top-4 right-4 z-10 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 p-2 rounded-xl shadow-sm" title="Validasi Selesai">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                @endif

                <div class="p-6 flex-grow">
                    <div class="w-14 h-14 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-extrabold text-slate-800 dark:text-white mb-2 line-clamp-2">
                        {{ $jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}
                    </h3>
                    
                    <div class="space-y-3 mt-5">
                        <div class="flex justify-between items-center bg-slate-50 dark:bg-slate-700/30 p-3 rounded-xl border border-slate-100 dark:border-slate-700/50">
                            <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Kebutuhan (Kuota)</span>
                            <span class="text-sm font-bold text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-500/20 px-2 py-1 rounded-lg">{{ $jabatan->kuota_kosong ?? 1 }} Orang</span>
                        </div>
                        <div class="flex justify-between items-center bg-slate-50 dark:bg-slate-700/30 p-3 rounded-xl border border-slate-100 dark:border-slate-700/50">
                            <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Kandidat Tersedia</span>
                            <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-100 dark:bg-indigo-500/20 px-2 py-1 rounded-lg">{{ $jumlahKandidat }} Orang</span>
                        </div>
                    </div>

                    <!-- Progress Bar Validasi -->
                    <div class="mt-6">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-semibold text-slate-500">Progress Validasi</span>
                            <span class="font-bold text-slate-700 dark:text-slate-300">{{ $sudahDivalidasi }}/{{ $jumlahKandidat }}</span>
                        </div>
                        <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>

                </div>
                
                <div class="p-4 border-t border-slate-100 dark:border-slate-700/50">
                    <a href="{{ route('validasi.show', $jabatan->id) }}" class="flex items-center justify-center gap-2 w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-colors font-semibold shadow-md shadow-indigo-200 dark:shadow-indigo-900/50">
                        Lihat Kandidat
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

@endif
@endsection
