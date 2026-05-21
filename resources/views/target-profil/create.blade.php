@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Tambah Target Profil</h1>
    <p class="text-slate-500 mt-2">Tentukan nilai target kompetensi (kriteria) untuk masing-masing jabatan.</p>
</div>

<div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm max-w-2xl">
    <form action="{{ route('target-profil.store') }}" method="POST">
        @csrf
        
        <div class="mb-5">
            <label class="block mb-2 text-sm font-bold text-slate-700" for="id_jabatan">Pilih Jabatan</label>
            <select id="id_jabatan" name="id_jabatan" class="w-full border border-slate-300 px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white" required>
                <option value="">-- Pilih Jabatan --</option>
                @foreach($jabatans as $jabatan)
                    <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-5">
            <label class="block mb-2 text-sm font-bold text-slate-700" for="id_kriteria">Pilih Kriteria</label>
            <select id="id_kriteria" name="id_kriteria" class="w-full border border-slate-300 px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white" required>
                <option value="">-- Pilih Kriteria --</option>
                @foreach($kriterias as $kriteria)
                    <option value="{{ $kriteria->id }}">{{ $kriteria->nama_kriteria }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-5">
            <label class="block mb-2 text-sm font-bold text-slate-700" for="nilai_target">Nilai Target (1 - 5)</label>
            <select id="nilai_target" name="nilai_target" class="w-full border border-slate-300 px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white" required>
                <option value="">-- Pilih Nilai Target --</option>
                <option value="1">1 - Sangat Kurang</option>
                <option value="2">2 - Kurang</option>
                <option value="3">3 - Cukup</option>
                <option value="4">4 - Baik</option>
                <option value="5">5 - Sangat Baik</option>
            </select>
        </div>

        <div class="mb-5">
            <label class="block mb-2 text-sm font-bold text-slate-700" for="tipe_faktor">Tipe Faktor</label>
            <select id="tipe_faktor" name="tipe_faktor" class="w-full border border-slate-300 px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white" required>
                <option value="">-- Pilih Tipe Faktor --</option>
                <option value="Core">Core Factor (Keahlian Utama)</option>
                <option value="Secondary">Secondary Factor (Keahlian Pendukung)</option>
            </select>
        </div>

        <div class="flex gap-3 mt-8">
            <a href="{{ route('target-profil.index') }}" class="px-5 py-2.5 text-slate-600 bg-slate-100 rounded-xl font-medium hover:bg-slate-200 transition-colors">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-indigo-700 transition-colors">Simpan Target</button>
        </div>
    </form>
</div>
@endsection
