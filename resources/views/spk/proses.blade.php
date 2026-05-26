@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Eksekusi SPK Profile Matching</h1>
    <p class="text-slate-500 dark:text-slate-400 mt-2 transition-colors duration-300">Proses algoritma pencocokan profil untuk menentukan rekomendasi rotasi jabatan yang paling optimal.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Status Data -->
    <div class="lg:col-span-2 bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 shadow-sm p-8 transition-all duration-300">
        <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            Kesiapan Data
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-slate-50 dark:bg-slate-700/30 p-6 rounded-2xl border border-slate-100 dark:border-slate-600/50">
                <div class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Total Kandidat (Pegawai)</div>
                <div class="text-3xl font-extrabold text-slate-800 dark:text-white">{{ $pegawais->count() }} <span class="text-base font-normal text-slate-500">Orang</span></div>
            </div>
            
            <div class="bg-slate-50 dark:bg-slate-700/30 p-6 rounded-2xl border border-slate-100 dark:border-slate-600/50">
                <div class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Status Penilaian</div>
                @if($dataBelumLengkap > 0)
                    <div class="text-3xl font-extrabold text-red-600 dark:text-red-400">{{ $dataBelumLengkap }} <span class="text-base font-normal text-red-500/80">Belum Dinilai</span></div>
                    <p class="text-xs text-red-500 mt-2">Peringatan: Pastikan semua data arsip & observasi telah diisi agar hasil akurat.</p>
                @else
                    <div class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400">100% <span class="text-base font-normal text-emerald-500/80">Lengkap</span></div>
                    <p class="text-xs text-emerald-500 mt-2">Semua data kandidat siap untuk diproses.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Action Panel -->
    <div class="bg-indigo-600 dark:bg-indigo-700 rounded-[2rem] shadow-xl shadow-indigo-200 dark:shadow-indigo-900/50 p-8 text-white flex flex-col justify-between relative overflow-hidden group">
        <!-- Abstract Decoration -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all duration-500"></div>
        
        <div class="relative z-10">
            <h2 class="text-xl font-bold mb-2">Mulai Perhitungan</h2>
            <p class="text-indigo-100 text-sm mb-6 leading-relaxed">
                Sistem akan membandingkan nilai riil (arsip & observasi) dengan nilai target jabatan (Target Profil) lalu mengkalkulasikan NCF dan NSF.
            </p>
        </div>

        <div class="relative z-10">
            <!-- Tombol Hitung ini diletakkan di luar form, kita hubungkan dengan atribut form="form-nominasi" -->
            <button type="submit" form="form-nominasi" class="w-full bg-white text-indigo-600 hover:bg-indigo-50 font-bold py-4 px-6 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                </svg>
                Hitung SPK Sekarang
            </button>
        </div>
    </div>
</div>

<!-- Daftar Pegawai Preview (Sekarang menjadi Form Nominasi) -->
<form id="form-nominasi" action="{{ route('spk.hitung') }}" method="POST">
    @csrf
    
    @error('jabatan_ids')
    <div class="bg-red-50 dark:bg-red-500/10 border-l-4 border-red-500 p-4 mb-4 rounded-r-2xl">
        <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ $message }}</p>
    </div>
    @enderror

    <!-- Nominasi Jabatan -->
    <div class="bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 shadow-sm overflow-hidden transition-all duration-300 mb-8">
        <div class="p-6 border-b border-slate-100 dark:border-slate-700/50 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 dark:text-white text-lg">Pilih Jabatan yang Dibuka (Kosong)</h3>
            <span class="text-xs text-slate-500 dark:text-slate-400">Centang jabatan yang akan dicari kandidatnya</span>
        </div>
        <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($jabatanTersedia as $item)
            <label class="flex items-start gap-3 p-4 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 cursor-pointer transition-colors group">
                <div class="flex items-center h-5">
                    <input type="checkbox" name="jabatan_ids[]" value="{{ $item->id_jabatan }}" class="w-5 h-5 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 cursor-pointer" checked>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $item->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui' }}</span>
                    <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Sistem akan mencocokkan kandidat ke posisi ini</span>
                </div>
            </label>
            @empty
            <div class="col-span-full p-4 text-center text-slate-500 dark:text-slate-400 text-sm bg-transparent">
                Belum ada data Target Profil yang dikonfigurasi. Silakan buat Target Profil terlebih dahulu.
            </div>
            @endforelse
        </div>
    </div>

    @error('nominasi_ids')
    <div class="bg-red-50 dark:bg-red-500/10 border-l-4 border-red-500 p-4 mb-4 rounded-r-2xl">
        <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ $message }}</p>
    </div>
    @enderror

    <div class="bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 shadow-sm overflow-hidden transition-all duration-300">
        <div class="p-6 border-b border-slate-100 dark:border-slate-700/50 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 dark:text-white text-lg">Nominasi Bursa Rotasi</h3>
            <span class="text-xs text-slate-500 dark:text-slate-400">Centang pegawai yang masuk bursa rotasi</span>
        </div>
        <div class="overflow-x-auto p-4">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                        <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50 first:rounded-l-xl text-center w-16">
                            <input type="checkbox" id="selectAll" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 cursor-pointer">
                        </th>
                        <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50">NIP</th>
                        <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50">Nama Pegawai</th>
                        <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50">Jabatan Saat Ini</th>
                        <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50 text-center">Status Penilaian</th>
                        <th class="py-3 px-4 font-semibold text-slate-600 dark:text-slate-300 text-sm border-b border-slate-100 dark:border-slate-700/50 text-center last:rounded-r-xl">Syarat Mutasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pegawais as $pegawai)
                    @php
                        $tmt = $pegawai->tmt_jabatan ? \Carbon\Carbon::parse($pegawai->tmt_jabatan) : null;
                        $masaJabatanThn = $tmt ? $tmt->diffInYears(now()) : 0;
                        $isEligible = true;
                        $tmsReason = [];
                        
                        if ($pegawai->hukuman_disiplin) {
                            $isEligible = false;
                            $tmsReason[] = 'Hukuman Disiplin';
                        }
                        if ($tmt && $masaJabatanThn < 2) {
                            $isEligible = false;
                            $tmsReason[] = 'Tenure < 2 Thn';
                        }
                        if (!$tmt) {
                            $isEligible = false;
                            $tmsReason[] = 'TMT Kosong';
                        }
                    @endphp
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors {{ !$isEligible ? 'opacity-60 bg-slate-50/50 dark:bg-slate-800/50' : '' }}">
                        <td class="py-3 px-4 border-b border-slate-100 dark:border-slate-700/50 text-center">
                            @if($isEligible)
                            <input type="checkbox" name="nominasi_ids[]" value="{{ $pegawai->id }}" class="nominasi-checkbox w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 cursor-pointer" checked>
                            @else
                            <input type="checkbox" disabled class="w-4 h-4 text-slate-300 bg-slate-100 border-slate-200 rounded cursor-not-allowed dark:bg-slate-700 dark:border-slate-600" title="Tidak Memenuhi Syarat">
                            @endif
                        </td>
                        <td class="py-3 px-4 border-b border-slate-100 dark:border-slate-700/50 text-slate-700 dark:text-slate-300 text-sm">{{ $pegawai->nip }}</td>
                        <td class="py-3 px-4 border-b border-slate-100 dark:border-slate-700/50 font-semibold text-slate-800 dark:text-slate-200 text-sm">{{ $pegawai->nama }}</td>
                        <td class="py-3 px-4 border-b border-slate-100 dark:border-slate-700/50 text-slate-600 dark:text-slate-400 text-sm">
                            {{ $pegawai->jabatan->nama_jabatan ?? '-' }}
                            @if($tmt)
                                <div class="text-[10px] text-slate-400 mt-0.5">TMT: {{ $tmt->format('d M Y') }} ({{ $masaJabatanThn }} thn)</div>
                            @endif
                        </td>
                        <td class="py-3 px-4 border-b border-slate-100 dark:border-slate-700/50 text-center flex flex-col items-center gap-1 bg-transparent">
                            @if($pegawai->arsip)
                                <span class="inline-flex items-center w-full justify-center px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400">Arsip: OK</span>
                            @else
                                <span class="inline-flex items-center w-full justify-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400">Arsip: X</span>
                            @endif

                            @if($pegawai->observasi)
                                <span class="inline-flex items-center w-full justify-center px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400">Observasi: OK</span>
                            @else
                                <span class="inline-flex items-center w-full justify-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400">Observasi: X</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 border-b border-slate-100 dark:border-slate-700/50 text-center">
                            @if($isEligible)
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/30">MS (Memenuhi Syarat)</span>
                            @else
                                <div class="flex flex-col items-center gap-1">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400 border border-red-200 dark:border-red-800/30">TMS</span>
                                    <span class="text-[10px] text-red-500 font-medium">{{ implode(', ', $tmsReason) }}</span>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.nominasi-checkbox');

        // Set all checked by default
        selectAllCheckbox.checked = true;

        selectAllCheckbox.addEventListener('change', function() {
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                // If one checkbox is unchecked, uncheck the select all checkbox
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                } else {
                    // Check if all checkboxes are checked
                    const allChecked = Array.from(checkboxes).every(c => c.checked);
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });

        // Loading state on calculation submission
        const formNominasi = document.getElementById('form-nominasi');
        const submitBtn = document.querySelector('button[form="form-nominasi"]');

        if (formNominasi && submitBtn) {
            formNominasi.addEventListener('submit', function() {
                // Disable the button to prevent multiple submissions
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed', 'hover:scale-100', 'active:scale-100');
                
                // Set loading spinner and text
                submitBtn.innerHTML = `
                    <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Sedang Mengalkulasi SPK...
                `;
            });
        }
    });
</script>
@endsection
