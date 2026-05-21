@extends('layouts.app')
@section('content')
<form action="{{ route('jabatan.store') }}" method="POST" class="bg-white p-8 rounded-2xl shadow-sm border max-w-lg">
    @csrf
    <label class="block mb-2 font-bold">Nama Jabatan</label>
    <input type="text" name="nama_jabatan" class="w-full border p-2 rounded mb-4">
    <label class="block mb-2 font-bold">Kuota</label>
    <input type="number" name="kuota_kosong" class="w-full border p-2 rounded mb-4">
    <button class="bg-indigo-600 text-white px-6 py-2 rounded-xl">Simpan</button>
</form>
@endsection