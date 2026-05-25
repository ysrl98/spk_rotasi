@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Edit Data Jabatan</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1 transition-colors duration-300">Ubah data formasi jabatan yang sudah ada.</p>
    </div>
    <a href="{{ route('jabatan.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-xl transition-colors font-semibold flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali
    </a>
</div>

<div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 shadow-sm p-8 rounded-3xl max-w-xl transition-colors duration-300">
    <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Nama Jabatan Input -->
        <div>
            <label class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300" for="nama_jabatan">Nama Jabatan</label>
            <input type="text" id="nama_jabatan" name="nama_jabatan" value="{{ old('nama_jabatan', $jabatan->nama_jabatan) }}"
                class="w-full border @error('nama_jabatan') border-red-500 focus:ring-red-500 @else border-slate-300 dark:border-slate-600 focus:ring-indigo-500 @enderror bg-white dark:bg-slate-700 text-slate-800 dark:text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm"
                placeholder="Masukkan nama jabatan..." required>
            @error('nama_jabatan')
                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kuota Input -->
        <div>
            <label class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300" for="kuota_kosong">Kuota Formasi (Kosong)</label>
            <input type="number" id="kuota_kosong" name="kuota_kosong" value="{{ old('kuota_kosong', $jabatan->kuota_kosong) }}" min="0"
                class="w-full border @error('kuota_kosong') border-red-500 focus:ring-red-500 @else border-slate-300 dark:border-slate-600 focus:ring-indigo-500 @enderror bg-white dark:bg-slate-700 text-slate-800 dark:text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all shadow-sm"
                placeholder="Masukkan kuota kebutuhan pegawai..." required>
            @error('kuota_kosong')
                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 mt-8 pt-4 border-t border-slate-100 dark:border-slate-700/50">
            <a href="{{ route('jabatan.index') }}" 
                class="px-5 py-2.5 text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl font-semibold transition-colors">Batal</a>
            <button type="submit" 
                class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 dark:shadow-indigo-900/20">Update Jabatan</button>
        </div>
    </form>
</div>
@endsection
