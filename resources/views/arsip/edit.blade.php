@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Input Nilai Arsip</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1 transition-colors duration-300">Form pengisian nilai objektif untuk pegawai: <strong class="text-indigo-600 dark:text-indigo-400 font-semibold">{{ $pegawai->nama }}</strong> (NIP: {{ $pegawai->nip }}).</p>
    </div>
    <a href="{{ route('arsip.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-xl transition-colors font-semibold flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali
    </a>
</div>

<div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 shadow-sm p-8 rounded-3xl max-w-2xl transition-colors duration-300">
    <form action="{{ route('arsip.update', $pegawai->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nilai Pendidikan -->
            <div>
                <label for="nilai_pendidikan" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nilai Pendidikan</label>
                <input type="number" min="1" max="5" name="nilai_pendidikan" id="nilai_pendidikan" value="{{ old('nilai_pendidikan', $arsip->nilai_pendidikan ?? '') }}" 
                    class="w-full border @error('nilai_pendidikan') border-red-500 focus:ring-red-500 @else border-slate-300 dark:border-slate-600 focus:ring-indigo-500 @enderror bg-white dark:bg-slate-700 text-slate-800 dark:text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm" placeholder="Skala 1-5" required>
                @error('nilai_pendidikan')
                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Nilai Masa Kerja -->
            <div>
                <label for="nilai_masa_kerja" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nilai Masa Kerja</label>
                <input type="number" min="1" max="5" name="nilai_masa_kerja" id="nilai_masa_kerja" value="{{ old('nilai_masa_kerja', $arsip->nilai_masa_kerja ?? '') }}" 
                    class="w-full border @error('nilai_masa_kerja') border-red-500 focus:ring-red-500 @else border-slate-300 dark:border-slate-600 focus:ring-indigo-500 @enderror bg-white dark:bg-slate-700 text-slate-800 dark:text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm" placeholder="Skala 1-5" required>
                @error('nilai_masa_kerja')
                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Nilai SKP -->
            <div>
                <label for="nilai_skp" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nilai SKP (Prestasi)</label>
                <input type="number" min="1" max="5" name="nilai_skp" id="nilai_skp" value="{{ old('nilai_skp', $arsip->nilai_skp ?? '') }}" 
                    class="w-full border @error('nilai_skp') border-red-500 focus:ring-red-500 @else border-slate-300 dark:border-slate-600 focus:ring-indigo-500 @enderror bg-white dark:bg-slate-700 text-slate-800 dark:text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm" placeholder="Skala 1-5" required>
                @error('nilai_skp')
                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Nilai Disiplin -->
            <div>
                <label for="nilai_disiplin" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nilai Disiplin</label>
                <input type="number" min="1" max="5" name="nilai_disiplin" id="nilai_disiplin" value="{{ old('nilai_disiplin', $arsip->nilai_disiplin ?? '') }}" 
                    class="w-full border @error('nilai_disiplin') border-red-500 focus:ring-red-500 @else border-slate-300 dark:border-slate-600 focus:ring-indigo-500 @enderror bg-white dark:bg-slate-700 text-slate-800 dark:text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm" placeholder="Skala 1-5" required>
                @error('nilai_disiplin')
                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 mt-8 pt-4 border-t border-slate-100 dark:border-slate-700/50">
            <a href="{{ route('arsip.index') }}" 
                class="px-5 py-2.5 text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl font-semibold transition-colors">Batal</a>
            <button type="submit" 
                class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 dark:shadow-indigo-900/20">Simpan Data</button>
        </div>
    </form>
</div>
@endsection
