@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Input Nilai Observasi</h1>
    <p class="text-slate-500 dark:text-slate-400 mt-2 transition-colors duration-300">Form pengisian nilai subjektif untuk pegawai: <strong class="text-indigo-600 dark:text-indigo-400">{{ $pegawai->nama }}</strong> (NIP: {{ $pegawai->nip }}).</p>
</div>

<div class="bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 shadow-sm p-8 transition-all duration-300 max-w-xl">
    <form action="{{ route('observasi.update', $pegawai->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 gap-6 mb-6">
            <div>
                <label for="nilai_inisiatif" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nilai Inisiatif</label>
                <input type="number" min="1" max="5" name="nilai_inisiatif" id="nilai_inisiatif" value="{{ $observasi->nilai_inisiatif ?? '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="Skala 1-5" required>
            </div>
            
            <div>
                <label for="nilai_kerjasama" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nilai Kerjasama</label>
                <input type="number" min="1" max="5" name="nilai_kerjasama" id="nilai_kerjasama" value="{{ $observasi->nilai_kerjasama ?? '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="Skala 1-5" required>
            </div>
        </div>

        <div class="flex gap-4 mt-8">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-medium shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 transition-all duration-300 transform hover:scale-105 active:scale-95">
                Simpan Penilaian
            </button>
            <a href="{{ route('observasi.index') }}" class="bg-white dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600 border border-slate-200 dark:border-slate-600 px-6 py-3 rounded-xl font-medium transition-all duration-300">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
