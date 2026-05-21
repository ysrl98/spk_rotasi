@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Tambah Data Kriteria</h1>
</div>

<div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm max-w-lg">
    <form action="{{ route('kriteria.store') }}" method="POST">
        @csrf
        
        <div class="mb-5">
            <label class="block mb-2 text-sm font-bold text-slate-700" for="nama_kriteria">Nama Kriteria</label>
            <input type="text" id="nama_kriteria" name="nama_kriteria" class="w-full border border-slate-300 px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="Masukkan nama kriteria..." required>
        </div>

        <div class="flex gap-3 mt-8">
            <a href="{{ route('kriteria.index') }}" class="px-5 py-2.5 text-slate-600 bg-slate-100 rounded-xl font-medium hover:bg-slate-200 transition-colors">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-indigo-700 transition-colors">Simpan Kriteria</button>
        </div>
    </form>
</div>
@endsection