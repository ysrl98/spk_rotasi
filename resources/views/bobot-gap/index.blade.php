@extends('layouts.app')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Data Bobot GAP</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-2 transition-colors duration-300">Kelola konversi selisih kompetensi menjadi nilai bobot.</p>
    </div>
    <a href="{{ route('bobot-gap.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-medium shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 transition-all duration-300 transform hover:scale-105 active:scale-95 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        Tambah Bobot GAP
    </a>
</div>

@if (session('success'))
<div class="bg-emerald-50 dark:bg-emerald-500/10 border-l-4 border-emerald-500 p-4 mb-8 rounded-r-2xl">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

<div class="bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 shadow-sm overflow-hidden transition-all duration-300">
    <div class="overflow-x-auto p-4">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                    <th class="py-4 px-6 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50 first:rounded-l-xl">Selisih (GAP)</th>
                    <th class="py-4 px-6 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50">Bobot Nilai</th>
                    <th class="py-4 px-6 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50 last:rounded-r-xl w-32 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bobotGaps as $item)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors group">
                    <td class="py-4 px-6 border-b border-slate-100 dark:border-slate-700/50 text-slate-700 dark:text-slate-300 font-medium">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $item->selisih == 0 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400' : ($item->selisih > 0 ? 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400' : 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400') }}">
                            {{ $item->selisih }}
                        </span>
                    </td>
                    <td class="py-4 px-6 border-b border-slate-100 dark:border-slate-700/50">
                        <span class="font-bold text-slate-800 dark:text-white">{{ $item->bobot }}</span>
                    </td>
                    <td class="py-4 px-6 border-b border-slate-100 dark:border-slate-700/50 text-center">
                        <div class="flex items-center justify-center gap-2 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-300">
                            <a href="{{ route('bobot-gap.edit', $item->id) }}" class="p-2 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-500/20 rounded-lg transition-colors" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </a>
                            <form action="{{ route('bobot-gap.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/20 rounded-lg transition-colors" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-8 text-center text-slate-500 dark:text-slate-400 bg-transparent">
                        Belum ada data Bobot GAP. Silakan jalankan seeder atau tambah data baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
