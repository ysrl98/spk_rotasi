@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-2xl font-bold text-slate-800">Data Kriteria</h1>
    <a href="{{ route('kriteria.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-indigo-700 transition">Tambah Kriteria</a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-slate-50">
            <tr class="text-slate-400 text-xs font-bold uppercase tracking-wider">
                <th class="px-6 py-4 w-16">No</th>
                <th class="px-6 py-4">Nama Kriteria</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($kriterias as $index => $k)
            <tr class="hover:bg-slate-50 transition border-b border-slate-50 last:border-none">
                <td class="px-6 py-4 font-semibold text-slate-800">{{ $index + 1 }}</td>
                <td class="px-6 py-4 text-slate-800">{{ $k->nama_kriteria }}</td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('kriteria.edit', $k->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 border border-transparent rounded-lg hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            Edit
                        </a>
                        <form action="{{ route('kriteria.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kriteria ini?');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-red-700 bg-red-50 border border-transparent rounded-lg hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-6 py-8 text-center text-slate-500">Belum ada data kriteria.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
