@extends('layouts.app')

@section('content')
<div class="mb-8 flex justify-between items-end">
    <div>
        <h1 class="text-3xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Hasil Rekomendasi Rotasi</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-2 transition-colors duration-300">Tabel peringkat kandidat terbaik untuk setiap posisi jabatan berdasarkan nilai Profile Matching.</p>
    </div>
    
    <div class="flex items-center gap-3">
        @php
            $adaDisetujui = \App\Models\HasilRotasi::where('status_validasi', 'Disetujui')->exists();
        @endphp

        @if($adaDisetujui && Auth::user()->role === 'Admin')
        <a href="{{ route('cetak.sk') }}" target="_blank" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl shadow-sm transition-all font-bold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
            </svg>
            Unduh SK Mutasi (PDF)
        </a>

        <form action="{{ route('spk.eksekusi') }}" method="POST" onsubmit="return confirm('PERINGATAN: Mengeksekusi mutasi akan secara PERMANEN memindahkan jabatan pegawai, mengubah kuota jabatan, dan mengosongkan layar hasil ini. Apakah Anda yakin ingin melanjutkan? Pastikan Anda sudah mengunduh SK!');">
            @csrf
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 transition-all font-bold flex items-center gap-2 animate-pulse hover:animate-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                </svg>
                Eksekusi Mutasi Permanen
            </button>
        </form>
        @endif
    </div>
</div>

@if($hasilPerJabatan->isEmpty())
<div class="bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 p-12 text-center shadow-sm">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-300 dark:text-slate-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
    </svg>
    <h3 class="text-lg font-bold text-slate-700 dark:text-slate-300 mb-1">Data Kosong</h3>
    <p class="text-slate-500 dark:text-slate-400">Belum ada hasil perhitungan SPK. Silakan lakukan proses perhitungan terlebih dahulu.</p>
    <a href="{{ route('spk.proses') }}" class="inline-block mt-6 px-6 py-2 bg-indigo-50 dark:bg-slate-700 text-indigo-600 dark:text-indigo-400 font-semibold rounded-lg hover:bg-indigo-100 dark:hover:bg-slate-600 transition-colors">
        Ke Halaman Proses
    </a>
</div>
@else

    <div class="space-y-8">
        @foreach($hasilPerJabatan as $nama_jabatan => $kandidat)
        <div class="bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 shadow-sm overflow-hidden transition-all duration-300">
            <!-- Header Jabatan -->
            <div class="bg-slate-50/50 dark:bg-slate-700/30 p-6 border-b border-slate-100 dark:border-slate-700/50 flex justify-between items-center">
                <div>
                    <span class="text-xs font-bold text-indigo-500 uppercase tracking-wider mb-1 block">Posisi Jabatan</span>
                    <h3 class="font-extrabold text-slate-800 dark:text-white text-xl">{{ $nama_jabatan }}</h3>
                </div>
                <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            
            <div class="overflow-x-auto p-4">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                            <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-xs uppercase tracking-wider border-b border-slate-100 dark:border-slate-700/50 first:rounded-l-xl text-center w-16">Peringkat</th>
                            <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-xs uppercase tracking-wider border-b border-slate-100 dark:border-slate-700/50">Nama Kandidat</th>
                            <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-xs uppercase tracking-wider border-b border-slate-100 dark:border-slate-700/50 text-center">Total Nilai Akhir</th>
                            <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-xs uppercase tracking-wider border-b border-slate-100 dark:border-slate-700/50 text-center last:rounded-r-xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kandidat as $index => $row)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors {{ $index === 0 ? 'bg-emerald-50/50 dark:bg-emerald-900/10' : '' }}">
                            <td class="py-4 px-4 border-b border-slate-100 dark:border-slate-700/50 text-center">
                                @if($index === 0)
                                    <div class="w-8 h-8 mx-auto bg-amber-400 text-amber-900 rounded-full flex items-center justify-center font-bold shadow-md">1</div>
                                @elseif($index === 1)
                                    <div class="w-8 h-8 mx-auto bg-slate-300 text-slate-700 rounded-full flex items-center justify-center font-bold shadow-sm">2</div>
                                @elseif($index === 2)
                                    <div class="w-8 h-8 mx-auto bg-amber-600 text-white rounded-full flex items-center justify-center font-bold shadow-sm">3</div>
                                @else
                                    <span class="text-slate-500 dark:text-slate-400 font-medium">{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 border-b border-slate-100 dark:border-slate-700/50">
                                <p class="font-bold text-slate-800 dark:text-slate-200">{{ $row->pegawai->nama }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $row->pegawai->nip }}</p>
                            </td>
                            <td class="py-4 px-4 border-b border-slate-100 dark:border-slate-700/50 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold {{ $index === 0 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400' : 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-200' }}">
                                    {{ number_format($row->nilai_total, 2) }}
                                </span>
                            </td>
                            <td class="py-4 px-4 border-b border-slate-100 dark:border-slate-700/50 text-center">
                                @if($row->detail_kalkulasi)
                                <button type="button" onclick='showDetailKalkulasi(@json($row->detail_kalkulasi), @json($row->pegawai->nama))' class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 dark:text-indigo-400 dark:bg-indigo-500/10 dark:hover:bg-indigo-500/20 rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                    Detail Perhitungan
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($kandidat->isNotEmpty() && $kandidat->first()->pegawai)
            <div class="p-5 bg-indigo-50/50 dark:bg-indigo-900/10 border-t border-indigo-100 dark:border-indigo-900/50">
                <div class="flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 dark:text-indigo-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-indigo-800 dark:text-indigo-300">
                        <strong class="font-semibold">{{ $kandidat->first()->pegawai->nama }}</strong> direkomendasikan untuk menempati jabatan <strong class="font-semibold">{{ $nama_jabatan }}</strong> karena memiliki persentase kecocokan profil (Nilai Akhir) tertinggi.
                    </p>
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>

@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function showDetailKalkulasi(detail, namaPegawai) {
        if (!detail || !detail.kriteria) {
            Swal.fire('Error', 'Detail kalkulasi tidak ditemukan (Mungkin kalkulasi lama).', 'error');
            return;
        }

        let tableRows = '';
        detail.kriteria.forEach(k => {
            let badgeClass = k.tipe_faktor === 'Core' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-700';
            tableRows += `
                <tr class="border-b border-slate-100 dark:border-slate-700">
                    <td class="text-left py-2 font-medium text-slate-800 dark:text-slate-200">${k.nama_kriteria}</td>
                    <td class="py-2"><span class="px-2 py-0.5 rounded text-xs font-bold ${badgeClass}">${k.tipe_faktor}</span></td>
                    <td class="py-2 text-center text-slate-600 dark:text-slate-300">${k.nilai_riil}</td>
                    <td class="py-2 text-center text-slate-600 dark:text-slate-300">${k.nilai_target}</td>
                    <td class="py-2 text-center font-bold text-rose-500">${k.gap}</td>
                    <td class="py-2 text-center font-bold text-emerald-600">${k.bobot}</td>
                </tr>
            `;
        });

        let htmlContent = `
            <div class="text-sm">
                <!-- RADAR CHART CONTAINER -->
                <div class="mb-4 bg-slate-50 dark:bg-slate-800 rounded-xl p-4 border border-slate-200 dark:border-slate-700">
                    <canvas id="radarChart" height="150"></canvas>
                </div>

                <div class="overflow-x-auto mb-4 border border-slate-200 dark:border-slate-700 rounded-lg">
                    <table class="w-full text-xs">
                        <thead class="bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                            <tr>
                                <th class="py-2 px-2 text-left">Kriteria</th>
                                <th class="py-2 px-2">Faktor</th>
                                <th class="py-2 px-2">Riil</th>
                                <th class="py-2 px-2">Target</th>
                                <th class="py-2 px-2">GAP</th>
                                <th class="py-2 px-2">Bobot</th>
                            </tr>
                        </thead>
                        <tbody>${tableRows}</tbody>
                    </table>
                </div>
                
                <div class="grid grid-cols-2 gap-3 mb-4 text-left">
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 p-3 rounded-lg border border-indigo-100 dark:border-indigo-800/50">
                        <p class="text-indigo-600 dark:text-indigo-400 text-xs font-bold mb-1">Core Factor (${detail.persen_core}%)</p>
                        <p class="text-xl font-black text-indigo-700 dark:text-indigo-300">${detail.ncf}</p>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-800 p-3 rounded-lg border border-slate-200 dark:border-slate-700">
                        <p class="text-slate-600 dark:text-slate-400 text-xs font-bold mb-1">Secondary Factor (${detail.persen_secondary}%)</p>
                        <p class="text-xl font-black text-slate-700 dark:text-slate-300">${detail.nsf}</p>
                    </div>
                </div>

                <div class="bg-emerald-50 dark:bg-emerald-900/20 p-4 rounded-xl border border-emerald-200 dark:border-emerald-800/50 text-center">
                    <p class="text-emerald-700 dark:text-emerald-400 text-xs font-bold mb-1">Formula Nilai Akhir</p>
                    <p class="text-lg font-black text-emerald-800 dark:text-emerald-300 font-mono">${detail.rumus_akhir}</p>
                </div>
            </div>
        `;

        Swal.fire({
            title: '<strong class="text-xl">Analisis Profil Kesenjangan</strong>',
            html: htmlContent,
            width: '600px',
            showCloseButton: true,
            showConfirmButton: false,
            customClass: {
                popup: 'rounded-[2rem] dark:bg-slate-900',
                title: 'text-slate-800 dark:text-white',
                htmlContainer: 'text-slate-600 dark:text-slate-300'
            },
            didOpen: () => {
                const ctx = document.getElementById('radarChart').getContext('2d');
                const labels = detail.kriteria.map(k => k.nama_kriteria);
                const dataTarget = detail.kriteria.map(k => k.nilai_target);
                const dataRiil = detail.kriteria.map(k => k.nilai_riil);

                new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Target Posisi (Yang Dibutuhkan)',
                                data: dataTarget,
                                backgroundColor: 'rgba(99, 102, 241, 0.2)',
                                borderColor: 'rgba(99, 102, 241, 1)',
                                pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                                borderWidth: 2,
                            },
                            {
                                label: 'Profil ' + namaPegawai + ' (Riil)',
                                data: dataRiil,
                                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                                borderColor: 'rgba(16, 185, 129, 1)',
                                pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                                borderWidth: 2,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            r: {
                                min: 0,
                                max: 5,
                                ticks: { stepSize: 1, backdropColor: 'transparent', display: false }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { boxWidth: 12, padding: 15 }
                            }
                        }
                    }
                });
            }
        });
    }
</script>
@endpush
