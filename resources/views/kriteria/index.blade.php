@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-2xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Data Kriteria</h1>
    <a href="{{ route('kriteria.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-indigo-700 transition">Tambah Kriteria</a>
</div>

<div class="bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-100 dark:border-slate-700/50 shadow-sm overflow-hidden transition-colors duration-300">
    <table class="w-full text-left">
        <thead class="bg-slate-50 dark:bg-slate-700/50">
            <tr class="text-slate-400 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                <th class="px-6 py-4 w-16">No</th>
                <th class="px-6 py-4">Nama Kriteria</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
            @forelse($kriterias as $index => $k)
            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition border-b border-slate-50 dark:border-slate-700/50 last:border-none">
                <td class="px-6 py-4 font-semibold text-slate-800 dark:text-white">{{ $index + 1 }}</td>
                <td class="px-6 py-4 text-slate-800 dark:text-slate-200">{{ $k->nama_kriteria }}</td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('kriteria.edit', $k->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10 border border-transparent rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-500/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            Edit
                        </a>
                        <form action="{{ route('kriteria.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kriteria ini?');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-500/10 border border-transparent rounded-lg hover:bg-red-100 dark:hover:bg-red-500/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-6 py-8 text-center text-slate-500 dark:text-slate-400 bg-transparent">Belum ada data kriteria.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
