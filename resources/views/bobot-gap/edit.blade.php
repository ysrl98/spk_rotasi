@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Edit Bobot GAP</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1 transition-colors duration-300">Ubah konversi nilai selisih kompetensi.</p>
    </div>
    <a href="{{ route('bobot-gap.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-xl transition-colors font-semibold flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali
    </a>
</div>

<div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 shadow-sm p-8 rounded-3xl max-w-xl transition-colors duration-300">
    <form action="{{ route('bobot-gap.update', $bobot_gap->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Selisih Input -->
        <div>
            <label for="selisih" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nilai Selisih (GAP)</label>
            <input type="number" step="0.01" name="selisih" id="selisih" value="{{ old('selisih', $bobot_gap->selisih) }}"
                class="w-full border @error('selisih') border-red-500 focus:ring-red-500 @else border-slate-300 dark:border-slate-600 focus:ring-indigo-500 @enderror bg-white dark:bg-slate-700 text-slate-800 dark:text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm" required>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Contoh: 1, 0, -1, 2, -2</p>
            @error('selisih')
                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Bobot Input -->
        <div>
            <label for="bobot" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Bobot Nilai</label>
            <input type="number" step="0.01" name="bobot" id="bobot" value="{{ old('bobot', $bobot_gap->bobot) }}"
                class="w-full border @error('bobot') border-red-500 focus:ring-red-500 @else border-slate-300 dark:border-slate-600 focus:ring-indigo-500 @enderror bg-white dark:bg-slate-700 text-slate-800 dark:text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm" required>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Contoh: 5, 4.5, 4, 3.5</p>
            @error('bobot')
                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 mt-8 pt-4 border-t border-slate-100 dark:border-slate-700/50">
            <a href="{{ route('bobot-gap.index') }}" 
                class="px-5 py-2.5 text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl font-semibold transition-colors">Batal</a>
            <button type="submit" 
                class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 dark:shadow-indigo-900/20">Update Data</button>
        </div>
    </form>
</div>
@endsection
