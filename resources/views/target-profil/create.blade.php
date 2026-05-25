@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Tambah Target Profil</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1 transition-colors duration-300">Tentukan nilai target kompetensi (kriteria) untuk masing-masing jabatan.</p>
    </div>
    <a href="{{ route('target-profil.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-xl transition-colors font-semibold flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali
    </a>
</div>

<div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 shadow-sm p-8 rounded-3xl max-w-xl transition-colors duration-300">
    <form action="{{ route('target-profil.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Jabatan Select -->
        <div>
            <label class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300" for="id_jabatan">Pilih Jabatan</label>
            <select id="id_jabatan" name="id_jabatan" 
                class="w-full border @error('id_jabatan') border-red-500 focus:ring-red-500 @else border-slate-300 dark:border-slate-600 focus:ring-indigo-500 @enderror bg-white dark:bg-slate-700 text-slate-800 dark:text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm" required>
                <option value="">-- Pilih Jabatan --</option>
                @foreach($jabatans as $jabatan)
                    <option value="{{ $jabatan->id }}" {{ old('id_jabatan') == $jabatan->id ? 'selected' : '' }}>{{ $jabatan->nama_jabatan }}</option>
                @endforeach
            </select>
            @error('id_jabatan')
                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kriteria Select -->
        <div>
            <label class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300" for="id_kriteria">Pilih Kriteria</label>
            <select id="id_kriteria" name="id_kriteria" 
                class="w-full border @error('id_kriteria') border-red-500 focus:ring-red-500 @else border-slate-300 dark:border-slate-600 focus:ring-indigo-500 @enderror bg-white dark:bg-slate-700 text-slate-800 dark:text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm" required>
                <option value="">-- Pilih Kriteria --</option>
                @foreach($kriterias as $kriteria)
                    <option value="{{ $kriteria->id }}" {{ old('id_kriteria') == $kriteria->id ? 'selected' : '' }}>{{ $kriteria->nama_kriteria }}</option>
                @endforeach
            </select>
            @error('id_kriteria')
                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nilai Target Select -->
        <div>
            <label class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300" for="nilai_target">Nilai Target (1 - 5)</label>
            <select id="nilai_target" name="nilai_target" 
                class="w-full border @error('nilai_target') border-red-500 focus:ring-red-500 @else border-slate-300 dark:border-slate-600 focus:ring-indigo-500 @enderror bg-white dark:bg-slate-700 text-slate-800 dark:text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm" required>
                <option value="">-- Pilih Nilai Target --</option>
                <option value="1" {{ old('nilai_target') == '1' ? 'selected' : '' }}>1 - Sangat Kurang</option>
                <option value="2" {{ old('nilai_target') == '2' ? 'selected' : '' }}>2 - Kurang</option>
                <option value="3" {{ old('nilai_target') == '3' ? 'selected' : '' }}>3 - Cukup</option>
                <option value="4" {{ old('nilai_target') == '4' ? 'selected' : '' }}>4 - Baik</option>
                <option value="5" {{ old('nilai_target') == '5' ? 'selected' : '' }}>5 - Sangat Baik</option>
            </select>
            @error('nilai_target')
                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tipe Faktor Select -->
        <div>
            <label class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300" for="tipe_faktor">Tipe Faktor</label>
            <select id="tipe_faktor" name="tipe_faktor" 
                class="w-full border @error('tipe_faktor') border-red-500 focus:ring-red-500 @else border-slate-300 dark:border-slate-600 focus:ring-indigo-500 @enderror bg-white dark:bg-slate-700 text-slate-800 dark:text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm" required>
                <option value="">-- Pilih Tipe Faktor --</option>
                <option value="Core" {{ old('tipe_faktor') == 'Core' ? 'selected' : '' }}>Core Factor (Keahlian Utama)</option>
                <option value="Secondary" {{ old('tipe_faktor') == 'Secondary' ? 'selected' : '' }}>Secondary Factor (Keahlian Pendukung)</option>
            </select>
            @error('tipe_faktor')
                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 mt-8 pt-4 border-t border-slate-100 dark:border-slate-700/50">
            <a href="{{ route('target-profil.index') }}" 
                class="px-5 py-2.5 text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl font-semibold transition-colors">Batal</a>
            <button type="submit" 
                class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 dark:shadow-indigo-900/20">Simpan Target</button>
        </div>
    </form>
</div>
@endsection
