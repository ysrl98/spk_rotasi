@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Tambah Bobot GAP</h1>
    <p class="text-slate-500 dark:text-slate-400 mt-2 transition-colors duration-300">Tambahkan konversi nilai selisih kompetensi baru.</p>
</div>

<div class="bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 shadow-sm p-8 transition-all duration-300 max-w-2xl">
    <form action="{{ route('bobot-gap.store') }}" method="POST">
        @csrf
        <div class="mb-6">
            <label for="selisih" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nilai Selisih (GAP)</label>
            <input type="number" step="0.01" name="selisih" id="selisih" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" required>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Contoh: 1, 0, -1, 2, -2</p>
        </div>

        <div class="mb-8">
            <label for="bobot" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Bobot Nilai</label>
            <input type="number" step="0.01" name="bobot" id="bobot" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" required>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Contoh: 5, 4.5, 4, 3.5</p>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-medium shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 transition-all duration-300 transform hover:scale-105 active:scale-95">
                Simpan Data
            </button>
            <a href="{{ route('bobot-gap.index') }}" class="bg-white dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600 border border-slate-200 dark:border-slate-600 px-6 py-3 rounded-xl font-medium transition-all duration-300">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
