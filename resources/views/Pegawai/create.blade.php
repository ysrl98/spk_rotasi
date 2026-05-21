@extends('layouts.app')
@section('content')
<form action="{{ route('pegawai.store') }}" method="POST" class="bg-white p-8 rounded-2xl shadow-sm border max-w-lg">
    @csrf
    <label class="block mb-2 font-bold">NIP</label><input type="text" name="nip" class="w-full border p-2 rounded mb-4" required>
    <label class="block mb-2 font-bold">Nama</label><input type="text" name="nama" class="w-full border p-2 rounded mb-4" required>
    <label class="block mb-2 font-bold">Jabatan</label>
    <select name="id_jabatan" class="w-full border p-2 rounded mb-4">
        @foreach($jabatans as $j)<option value="{{ $j->id }}">{{ $j->nama_jabatan }}</option>@endforeach
    </select>
    <button class="bg-indigo-600 text-white px-6 py-2 rounded-xl">Simpan</button>
</form>
@endsection