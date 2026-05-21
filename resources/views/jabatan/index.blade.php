@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-2xl font-bold text-slate-800">Data Jabatan</h1> 
    @if(Auth::user()->role === 'Admin')
    <a href="{{ route('jabatan.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-indigo-700 transition">Tambah Jabatan</a>
    @endif
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-slate-50">
            <tr class="text-slate-400 text-xs font-bold uppercase tracking-wider">
                <th class="px-6 py-4">Nama Jabatan</th>
                <th class="px-6 py-4">Kuota</th>
                @if(Auth::user()->role === 'Admin')
                <th class="px-6 py-4 text-right">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            {{-- Pastikan menggunakan $jabatans sesuai dengan Controller --}}
            @foreach($jabatans as $j) 
            <tr class="hover:bg-slate-50 transition border-b border-slate-50 last:border-none">
                <td class="px-6 py-4 font-semibold text-slate-800">{{ $j->nama_jabatan }}</td>
                <td class="px-6 py-4 text-slate-500">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $j->kuota_kosong }} Orang
                    </span>
                </td>
                @if(Auth::user()->role === 'Admin')
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('jabatan.edit', $j->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 border border-transparent rounded-lg hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            Edit
                        </a>
                        <form action="{{ route('jabatan.destroy', $j->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data jabatan ini?');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-red-700 bg-red-50 border border-transparent rounded-lg hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection