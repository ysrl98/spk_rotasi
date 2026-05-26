@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Profil Pegawai</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1 transition-colors duration-300">Detail informasi profil dan riwayat penilaian pegawai.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-colors font-semibold flex items-center gap-2 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Profil
        </a>
        <a href="{{ route('pegawai.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-xl transition-colors font-semibold flex items-center gap-2 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Kolom Kiri: Informasi Personal & Jabatan -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Kartu Identitas -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-slate-100 dark:border-slate-700/50 flex flex-col items-center text-center">
            <div class="w-24 h-24 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center text-3xl font-bold mb-4">
                {{ substr($pegawai->nama, 0, 1) }}
            </div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-white">{{ $pegawai->nama }}</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium mt-1">{{ $pegawai->nip }}</p>
            
            <div class="mt-4 px-3 py-1 bg-slate-100 dark:bg-slate-700 rounded-full text-xs font-semibold text-slate-600 dark:text-slate-300">
                {{ $pegawai->pangkat }} - {{ $pegawai->golongan }}
            </div>
        </div>

        <!-- Kartu Jabatan & Syarat -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-slate-100 dark:border-slate-700/50">
            <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider mb-4 border-b border-slate-100 dark:border-slate-700/50 pb-2">Informasi Jabatan</h3>
            
            <div class="space-y-4">
                <div>
                    <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">Jabatan Saat Ini</div>
                    <div class="font-semibold text-slate-800 dark:text-slate-200">{{ $pegawai->jabatan->nama_jabatan ?? 'Belum ada jabatan' }}</div>
                </div>

                @php
                    $tmt = $pegawai->tmt_jabatan ? \Carbon\Carbon::parse($pegawai->tmt_jabatan) : null;
                    $masaJabatanThn = $tmt ? $tmt->diffInYears(now()) : 0;
                    $masaJabatanBln = $tmt ? $tmt->diffInMonths(now()) % 12 : 0;
                @endphp
                
                <div>
                    <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">TMT Jabatan (Tenure)</div>
                    <div class="font-semibold text-slate-800 dark:text-slate-200">
                        @if($tmt)
                            {{ $tmt->format('d F Y') }} <br>
                            <span class="text-sm text-indigo-600 dark:text-indigo-400">({{ $masaJabatanThn }} Tahun, {{ $masaJabatanBln }} Bulan)</span>
                        @else
                            <span class="text-red-500">- Belum Diatur -</span>
                        @endif
                    </div>
                </div>

                <div>
                    <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">Status Disiplin</div>
                    @if($pegawai->hukuman_disiplin)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400">Sedang Dihukum Disiplin</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400">Bersih</span>
                    @endif
                </div>
                
                <div class="pt-4 mt-2 border-t border-slate-100 dark:border-slate-700/50">
                    <div class="text-xs text-slate-500 dark:text-slate-400 mb-2">Kelayakan Rotasi (SPK)</div>
                    @if(!$pegawai->hukuman_disiplin && $tmt && $masaJabatanThn >= 2)
                        <div class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Memenuhi Syarat (MS)
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-red-600 dark:text-red-400 font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            Tidak Memenuhi Syarat (TMS)
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Penilaian Arsip & Observasi -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Arsip Penilaian (Objektif) -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-slate-100 dark:border-slate-700/50">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                    </svg>
                    Data Arsip (Nilai Objektif)
                </h3>
                @if(!$pegawai->arsip)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400">Belum Dinilai</span>
                @endif
            </div>

            @if($pegawai->arsip)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-100 dark:border-slate-600/50 text-center">
                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1">Pendidikan</div>
                        <div class="text-2xl font-black text-slate-800 dark:text-white">{{ $pegawai->arsip->nilai_pendidikan }}</div>
                    </div>
                    <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-100 dark:border-slate-600/50 text-center">
                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1">Masa Kerja</div>
                        <div class="text-2xl font-black text-slate-800 dark:text-white">{{ $pegawai->arsip->nilai_masa_kerja }}</div>
                    </div>
                    <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-100 dark:border-slate-600/50 text-center">
                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1">SKP</div>
                        <div class="text-2xl font-black text-slate-800 dark:text-white">{{ $pegawai->arsip->nilai_skp }}</div>
                    </div>
                    <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-100 dark:border-slate-600/50 text-center">
                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1">Disiplin</div>
                        <div class="text-2xl font-black text-slate-800 dark:text-white">{{ $pegawai->arsip->nilai_disiplin }}</div>
                    </div>
                </div>
            @else
                <div class="p-8 text-center text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-700/30 rounded-2xl border border-dashed border-slate-300 dark:border-slate-600">
                    Data penilaian objektif belum diisi oleh Bagian Kepegawaian (Admin).
                </div>
            @endif
        </div>

        <!-- Observasi (Subjektif) -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-slate-100 dark:border-slate-700/50">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    </svg>
                    Data Observasi (Penilaian Atasan)
                </h3>
                @if(!$pegawai->observasi)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400">Belum Dinilai</span>
                @endif
            </div>

            @if($pegawai->observasi)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-emerald-50 dark:bg-emerald-500/10 rounded-2xl border border-emerald-100 dark:border-emerald-500/20 text-center">
                        <div class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 mb-1">Inisiatif</div>
                        <div class="text-3xl font-black text-emerald-800 dark:text-emerald-300">{{ $pegawai->observasi->nilai_inisiatif }}</div>
                    </div>
                    <div class="p-4 bg-emerald-50 dark:bg-emerald-500/10 rounded-2xl border border-emerald-100 dark:border-emerald-500/20 text-center">
                        <div class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 mb-1">Kerjasama</div>
                        <div class="text-3xl font-black text-emerald-800 dark:text-emerald-300">{{ $pegawai->observasi->nilai_kerjasama }}</div>
                    </div>
                </div>
                <div class="mt-4 text-xs text-slate-500 dark:text-slate-400">
                    Dinilai oleh Atasan ID: {{ $pegawai->observasi->id_penilai }} pada {{ $pegawai->observasi->updated_at->format('d M Y') }}
                </div>
            @else
                <div class="p-8 text-center text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-700/30 rounded-2xl border border-dashed border-slate-300 dark:border-slate-600">
                    Data penilaian subjektif belum dilakukan oleh Atasan Langsung.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
