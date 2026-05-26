@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Pengaturan Algoritma SPK</h1>
    <p class="text-slate-500 dark:text-slate-400 mt-2 transition-colors duration-300">Sesuaikan persentase bobot parameter Profile Matching secara dinamis.</p>
</div>

<div class="bg-white dark:bg-slate-800 rounded-3xl p-8 border border-slate-100 dark:border-slate-700 shadow-sm max-w-3xl">
    <form action="{{ route('pengaturan.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300 p-4 rounded-xl text-sm border border-blue-100 dark:border-blue-800/50">
            <strong>Catatan:</strong> Total persentase Core Factor (NCF) dan Secondary Factor (NSF) harus berjumlah tepat <strong>100%</strong>.
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Core Factor -->
            <div class="p-6 bg-indigo-50 dark:bg-indigo-900/10 rounded-2xl border border-indigo-100 dark:border-indigo-800/50">
                <label class="block text-sm font-bold text-indigo-700 dark:text-indigo-400 mb-2">Bobot Core Factor (NCF)</label>
                <div class="flex items-center gap-3">
                    <input type="number" id="persen_core" name="persen_core" value="{{ old('persen_core', $pengaturan->persen_core ?? 60) }}" min="0" max="100" class="block w-full px-4 py-3 bg-white dark:bg-slate-900 border-2 border-indigo-200 dark:border-indigo-700 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 dark:text-white transition-all text-xl font-black text-center" oninput="autoCalculate('core')">
                    <span class="text-2xl font-black text-indigo-300 dark:text-indigo-600">%</span>
                </div>
                <p class="text-xs text-indigo-500 dark:text-indigo-400 mt-3 opacity-80">Persentase bobot untuk kriteria bernilai Core.</p>
            </div>

            <!-- Secondary Factor -->
            <div class="p-6 bg-emerald-50 dark:bg-emerald-900/10 rounded-2xl border border-emerald-100 dark:border-emerald-800/50">
                <label class="block text-sm font-bold text-emerald-700 dark:text-emerald-400 mb-2">Bobot Secondary Factor (NSF)</label>
                <div class="flex items-center gap-3">
                    <input type="number" id="persen_secondary" name="persen_secondary" value="{{ old('persen_secondary', $pengaturan->persen_secondary ?? 40) }}" min="0" max="100" class="block w-full px-4 py-3 bg-white dark:bg-slate-900 border-2 border-emerald-200 dark:border-emerald-700 rounded-xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 dark:text-white transition-all text-xl font-black text-center" oninput="autoCalculate('secondary')">
                    <span class="text-2xl font-black text-emerald-300 dark:text-emerald-600">%</span>
                </div>
                <p class="text-xs text-emerald-500 dark:text-emerald-400 mt-3 opacity-80">Persentase bobot untuk kriteria bernilai Secondary.</p>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <button type="submit" class="px-6 py-3 bg-slate-800 dark:bg-indigo-600 hover:bg-slate-900 dark:hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all">
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function autoCalculate(changed) {
        const coreInput = document.getElementById('persen_core');
        const secondaryInput = document.getElementById('persen_secondary');
        
        if (changed === 'core') {
            let coreVal = parseInt(coreInput.value) || 0;
            if (coreVal > 100) coreVal = 100;
            if (coreVal < 0) coreVal = 0;
            secondaryInput.value = 100 - coreVal;
        } else {
            let secVal = parseInt(secondaryInput.value) || 0;
            if (secVal > 100) secVal = 100;
            if (secVal < 0) secVal = 0;
            coreInput.value = 100 - secVal;
        }
    }
</script>
@endpush
@endsection
