@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-2xl font-bold text-slate-800">Data Target Profil</h1>
    <a href="{{ route('target-profil.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-indigo-700 transition">Tambah Target</a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-slate-50">
            <tr class="text-slate-400 text-xs font-bold uppercase tracking-wider">
                <th class="px-6 py-4">No</th>
                <th class="px-6 py-4">Jabatan</th>
                <th class="px-6 py-4">Kriteria</th>
                <th class="px-6 py-4">Nilai Target (1-5)</th>
                <th class="px-6 py-4">Tipe Faktor</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($targetProfils as $index => $tp)
            @php
                // Cari nama jabatan dan kriteria karena relasi belum terdefinisi di model
                $jabatan = $jabatans->firstWhere('id', $tp->id_jabatan);
                $kriteria = $kriterias->firstWhere('id', $tp->id_kriteria);
            @endphp
            <tr class="hover:bg-slate-50 transition border-b border-slate-50 last:border-none">
                <td class="px-6 py-4 font-semibold text-slate-800">{{ $index + 1 }}</td>
                <td class="px-6 py-4 text-slate-800">{{ $jabatan ? $jabatan->nama_jabatan : '-' }}</td>
                <td class="px-6 py-4 text-slate-800">{{ $kriteria ? $kriteria->nama_kriteria : '-' }}</td>
                <td class="px-6 py-4 text-slate-800 font-bold text-center w-32">{{ $tp->nilai_target }}</td>
                <td class="px-6 py-4 text-slate-500">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $tp->tipe_faktor == 'Core' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $tp->tipe_faktor }} Factor
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-2">
                        <form action="{{ route('target-profil.destroy', $tp->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data target profil ini?');" class="inline-block">
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
                <td colspan="6" class="px-6 py-8 text-center text-slate-500">Belum ada data target profil.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
