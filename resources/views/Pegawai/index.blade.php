@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-2xl font-bold text-slate-800">Data Pegawai</h1>
    <a href="{{ route('pegawai.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-indigo-700 transition">Tambah Pegawai</a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-slate-50">
            <tr class="text-slate-400 text-xs font-bold uppercase tracking-wider">
                <th class="px-6 py-4">NIP</th>
                <th class="px-6 py-4">Nama</th>
                <th class="px-6 py-4">Jabatan</th>
                <th class="px-6 py-4">Pangkat</th>
                <th class="px-6 py-4">Golongan</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @foreach($pegawais as $p)
            <tr class="hover:bg-slate-50 transition border-b border-slate-50 last:border-none">
                <td class="px-6 py-4 font-semibold text-slate-800">{{ $p->nip }}</td>
                <td class="px-6 py-4 text-slate-800">{{ $p->nama }}</td>
                <td class="px-6 py-4 text-slate-500">{{ $p->jabatan->nama_jabatan ?? '-' }}</td>
                <td class="px-6 py-4 text-slate-500">{{ $p->pangkat }}</td>
                <td class="px-6 py-4 text-slate-500">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                        {{ $p->golongan }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('pegawai.edit', $p->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 border border-transparent rounded-lg hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            Edit
                        </a>
                        <form action="{{ route('pegawai.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pegawai ini?');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-red-700 bg-red-50 border border-transparent rounded-lg hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection