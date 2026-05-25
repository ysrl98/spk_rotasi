@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Edit Data Kriteria</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1 transition-colors duration-300">Ubah data kriteria kompetensi yang sudah ada.</p>
    </div>
    <a href="{{ route('kriteria.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-xl transition-colors font-semibold flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali
    </a>
</div>

<div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 shadow-sm p-8 rounded-3xl max-w-xl transition-colors duration-300">
    <form action="{{ route('kriteria.update', $kriteria->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Nama Kriteria Input -->
        <div>
            <label class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300" for="nama_kriteria">Nama Kriteria</label>
            <input type="text" id="nama_kriteria" name="nama_kriteria" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}"
                class="w-full border @error('nama_kriteria') border-red-500 focus:ring-red-500 @else border-slate-300 dark:border-slate-600 focus:ring-indigo-500 @enderror bg-white dark:bg-slate-700 text-slate-800 dark:text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm"
                placeholder="Masukkan nama kriteria (contoh: Kedisiplinan)..." required>
            @error('nama_kriteria')
                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Sumber Nilai Select -->
        <div>
            <label class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300" for="sumber_nilai">Sumber Nilai (Mapping Data)</label>
            <select id="sumber_nilai" name="sumber_nilai" 
                class="w-full border @error('sumber_nilai') border-red-500 focus:ring-red-500 @else border-slate-300 dark:border-slate-600 focus:ring-indigo-500 @enderror bg-white dark:bg-slate-700 text-slate-800 dark:text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm" required>
                <option value="">-- Pilih Sumber Nilai --</option>
                <optgroup label="Data Arsip Objektif" class="bg-white dark:bg-slate-800">
                    <option value="arsip.nilai_pendidikan" {{ old('sumber_nilai', $kriteria->sumber_nilai) == 'arsip.nilai_pendidikan' ? 'selected' : '' }}>Nilai Pendidikan</option>
                    <option value="arsip.nilai_masa_kerja" {{ old('sumber_nilai', $kriteria->sumber_nilai) == 'arsip.nilai_masa_kerja' ? 'selected' : '' }}>Nilai Masa Kerja</option>
                    <option value="arsip.nilai_skp" {{ old('sumber_nilai', $kriteria->sumber_nilai) == 'arsip.nilai_skp' ? 'selected' : '' }}>Nilai SKP</option>
                    <option value="arsip.nilai_disiplin" {{ old('sumber_nilai', $kriteria->sumber_nilai) == 'arsip.nilai_disiplin' ? 'selected' : '' }}>Nilai Disiplin</option>
                </optgroup>
                <optgroup label="Data Observasi Subjektif" class="bg-white dark:bg-slate-800">
                    <option value="observasi.nilai_inisiatif" {{ old('sumber_nilai', $kriteria->sumber_nilai) == 'observasi.nilai_inisiatif' ? 'selected' : '' }}>Nilai Inisiatif</option>
                    <option value="observasi.nilai_kerjasama" {{ old('sumber_nilai', $kriteria->sumber_nilai) == 'observasi.nilai_kerjasama' ? 'selected' : '' }}>Nilai Kerja Sama</option>
                </optgroup>
            </select>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Pilih dari mana nilai riil kriteria ini akan diambil saat perhitungan SPK.</p>
            @error('sumber_nilai')
                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 mt-8 pt-4 border-t border-slate-100 dark:border-slate-700/50">
            <a href="{{ route('kriteria.index') }}" 
                class="px-5 py-2.5 text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl font-semibold transition-colors">Batal</a>
            <button type="submit" 
                class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 dark:shadow-indigo-900/20">Update Kriteria</button>
        </div>
    </form>
</div>
@endsection
