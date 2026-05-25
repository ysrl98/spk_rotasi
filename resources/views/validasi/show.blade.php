@extends('layouts.app')

@section('content')
<div class="mb-8 flex justify-between items-end">
    <div>
        <h1 class="text-3xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Validasi Kandidat</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-2 transition-colors duration-300">Bidang: <strong class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $jabatan->nama_jabatan }}</strong></p>
    </div>
    <a href="{{ route('validasi.index') }}" class="px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors font-semibold flex items-center gap-2 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali
    </a>
</div>

@if (session('success'))
<div class="bg-emerald-50 dark:bg-emerald-500/10 border-l-4 border-emerald-500 p-4 mb-8 rounded-r-2xl">
    <div class="flex items-center">
        <div class="ml-3">
            <p class="text-sm font-medium text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

@if (session('error'))
<div class="bg-red-50 dark:bg-red-500/10 border-l-4 border-red-500 p-4 mb-8 rounded-r-2xl">
    <div class="flex items-center">
        <div class="ml-3">
            <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
        </div>
    </div>
</div>
@endif

<div class="bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 shadow-sm overflow-hidden transition-colors duration-300">
    <div class="bg-indigo-50/50 dark:bg-indigo-900/10 p-6 border-b border-indigo-100 dark:border-indigo-900/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="font-extrabold text-slate-800 dark:text-white text-xl">Daftar Peringkat</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Sistem merekomendasikan kandidat peringkat atas berdasarkan Nilai Akhir tertinggi.</p>
        </div>
        <div class="bg-white dark:bg-slate-800 px-4 py-2 rounded-xl border border-indigo-100 dark:border-slate-700 shadow-sm flex items-center gap-2">
            <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Kebutuhan:</span>
            <span class="text-lg font-bold text-red-600 dark:text-red-400">{{ $jabatan->kuota_kosong }}</span>
        </div>
    </div>
    
    @php
        $jumlahDisetujui = $kandidat->where('status_validasi', 'Disetujui')->count();
        $kuotaPenuh = $jumlahDisetujui >= $jabatan->kuota_kosong;
    @endphp

    <div class="overflow-x-auto p-4">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                    <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-xs uppercase tracking-wider text-center w-16">Peringkat</th>
                    <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-xs uppercase tracking-wider">Nama Kandidat</th>
                    <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-xs uppercase tracking-wider text-center">Nilai Akhir</th>
                    <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-xs uppercase tracking-wider text-center">Status</th>
                    <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-xs uppercase tracking-wider text-center">Aksi Validasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kandidat as $index => $row)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors {{ $index === 0 ? 'bg-emerald-50/50 dark:bg-emerald-900/10' : '' }}">
                    <td class="py-4 px-4 text-center border-b border-slate-100 dark:border-slate-700/50">
                        @if($index === 0)
                            <div class="w-8 h-8 mx-auto bg-amber-400 text-amber-900 rounded-full flex items-center justify-center font-bold">1</div>
                        @else
                            <span class="text-slate-500 dark:text-slate-400 font-medium">{{ $index + 1 }}</span>
                        @endif
                    </td>
                    <td class="py-4 px-4 border-b border-slate-100 dark:border-slate-700/50">
                        <p class="font-bold text-slate-800 dark:text-slate-200">{{ $row->pegawai->nama }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $row->pegawai->nip }}</p>
                    </td>
                    <td class="py-4 px-4 text-center border-b border-slate-100 dark:border-slate-700/50">
                        <span class="font-bold text-slate-700 dark:text-slate-300">{{ number_format($row->nilai_total, 2) }}</span>
                    </td>
                    <td class="py-4 px-4 text-center border-b border-slate-100 dark:border-slate-700/50">
                        @if($row->status_validasi === 'Disetujui')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400">Disetujui</span>
                        @elseif($row->status_validasi === 'Ditolak')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400">Ditolak</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400">Menunggu</span>
                        @endif
                    </td>
                    <td class="py-4 px-4 text-center border-b border-slate-100 dark:border-slate-700/50">
                        @if($row->status_validasi === 'Menunggu')
                        <div class="flex items-center justify-center gap-2">
                            @if(!$kuotaPenuh)
                            <form action="{{ route('validasi.setuju', $row->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg transition-colors shadow-sm" title="Setujui Rotasi">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                </button>
                            </form>
                            @else
                            <button type="button" class="p-2 bg-slate-200 dark:bg-slate-700 text-slate-400 dark:text-slate-500 rounded-lg cursor-not-allowed shadow-sm" title="Kuota Sudah Penuh">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            </button>
                            @endif
                            <form action="{{ route('validasi.tolak', $row->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors shadow-sm" title="Tolak Rotasi">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </form>
                        </div>
                        @else
                        <div class="flex flex-col items-center justify-center gap-1">
                            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest flex items-center justify-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Divalidasi
                            </span>
                            <form action="{{ route('validasi.batal', $row->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[10px] text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-400 underline transition-colors focus:outline-none">
                                    Batalkan
                                </button>
                            </form>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
