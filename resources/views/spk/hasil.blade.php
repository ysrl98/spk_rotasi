@extends('layouts.app')

@section('content')
<div class="mb-8 flex justify-between items-end">
    <div>
        <h1 class="text-3xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Hasil Rekomendasi Rotasi</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-2 transition-colors duration-300">Tabel peringkat kandidat terbaik untuk setiap posisi jabatan berdasarkan nilai Profile Matching.</p>
    </div>
    
    <div class="flex items-center gap-3">
        @php
            $adaDisetujui = \App\Models\HasilRotasi::where('status_validasi', 'Disetujui')->exists();
        @endphp

        @if($adaDisetujui && Auth::user()->role === 'Admin')
        <form action="{{ route('spk.eksekusi') }}" method="POST" onsubmit="return confirm('PERINGATAN: Mengeksekusi mutasi akan secara PERMANEN memindahkan jabatan pegawai, mengubah kuota jabatan, dan mengosongkan layar hasil ini. Apakah Anda yakin ingin melanjutkan?');">
            @csrf
            <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl shadow-lg shadow-rose-200 dark:shadow-rose-900/50 transition-all font-bold flex items-center gap-2 animate-pulse hover:animate-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                </svg>
                Eksekusi Mutasi Permanen
            </button>
        </form>
        @endif
    </div>
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

@if($hasilPerJabatan->isEmpty())
<div class="bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 p-12 text-center shadow-sm">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-300 dark:text-slate-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
    </svg>
    <h3 class="text-lg font-bold text-slate-700 dark:text-slate-300 mb-1">Data Kosong</h3>
    <p class="text-slate-500 dark:text-slate-400">Belum ada hasil perhitungan SPK. Silakan lakukan proses perhitungan terlebih dahulu.</p>
    <a href="{{ route('spk.proses') }}" class="inline-block mt-6 px-6 py-2 bg-indigo-50 dark:bg-slate-700 text-indigo-600 dark:text-indigo-400 font-semibold rounded-lg hover:bg-indigo-100 dark:hover:bg-slate-600 transition-colors">
        Ke Halaman Proses
    </a>
</div>
@else

    <div class="space-y-8">
        @foreach($hasilPerJabatan as $nama_jabatan => $kandidat)
        <div class="bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 shadow-sm overflow-hidden transition-all duration-300">
            <!-- Header Jabatan -->
            <div class="bg-slate-50/50 dark:bg-slate-700/30 p-6 border-b border-slate-100 dark:border-slate-700/50 flex justify-between items-center">
                <div>
                    <span class="text-xs font-bold text-indigo-500 uppercase tracking-wider mb-1 block">Posisi Jabatan</span>
                    <h3 class="font-extrabold text-slate-800 dark:text-white text-xl">{{ $nama_jabatan }}</h3>
                </div>
                <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            
            <div class="overflow-x-auto p-4">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                            <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-xs uppercase tracking-wider border-b border-slate-100 dark:border-slate-700/50 first:rounded-l-xl text-center w-16">Peringkat</th>
                            <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-xs uppercase tracking-wider border-b border-slate-100 dark:border-slate-700/50">Nama Kandidat</th>
                            <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-xs uppercase tracking-wider border-b border-slate-100 dark:border-slate-700/50 text-center last:rounded-r-xl">Total Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kandidat as $index => $row)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors {{ $index === 0 ? 'bg-emerald-50/50 dark:bg-emerald-900/10' : '' }}">
                            <td class="py-4 px-4 border-b border-slate-100 dark:border-slate-700/50 text-center">
                                @if($index === 0)
                                    <div class="w-8 h-8 mx-auto bg-amber-400 text-amber-900 rounded-full flex items-center justify-center font-bold shadow-md">1</div>
                                @elseif($index === 1)
                                    <div class="w-8 h-8 mx-auto bg-slate-300 text-slate-700 rounded-full flex items-center justify-center font-bold shadow-sm">2</div>
                                @elseif($index === 2)
                                    <div class="w-8 h-8 mx-auto bg-amber-600 text-white rounded-full flex items-center justify-center font-bold shadow-sm">3</div>
                                @else
                                    <span class="text-slate-500 dark:text-slate-400 font-medium">{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 border-b border-slate-100 dark:border-slate-700/50">
                                <p class="font-bold text-slate-800 dark:text-slate-200">{{ $row->pegawai->nama }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $row->pegawai->nip }}</p>
                            </td>
                            <td class="py-4 px-4 border-b border-slate-100 dark:border-slate-700/50 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold {{ $index === 0 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400' : 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-200' }}">
                                    {{ number_format($row->nilai_total, 2) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($kandidat->isNotEmpty() && $kandidat->first()->pegawai)
            <div class="p-5 bg-indigo-50/50 dark:bg-indigo-900/10 border-t border-indigo-100 dark:border-indigo-900/50">
                <div class="flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 dark:text-indigo-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-indigo-800 dark:text-indigo-300">
                        <strong class="font-semibold">{{ $kandidat->first()->pegawai->nama }}</strong> direkomendasikan untuk menempati jabatan <strong class="font-semibold">{{ $nama_jabatan }}</strong> karena memiliki persentase kecocokan profil (Nilai Akhir) tertinggi.
                    </p>
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>

@endif
@endsection
