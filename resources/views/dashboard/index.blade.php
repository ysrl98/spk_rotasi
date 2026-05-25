@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white transition-colors duration-300">Dashboard</h1>
    <p class="text-slate-500 dark:text-slate-400 mt-2 transition-colors duration-300">Selamat datang, Anda login sebagai <strong>{{ $role ?? 'User' }}</strong>.</p>
</div>

<!-- Statistik Cards Row -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card Pegawai -->
    <div class="bg-white dark:bg-slate-800/80 p-6 rounded-3xl border border-slate-100 dark:border-slate-700/50 shadow-sm flex items-center gap-4 hover:shadow-md transition-all duration-300 group">
        <div class="w-14 h-14 rounded-full bg-indigo-50 dark:bg-indigo-500/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Pegawai</p>
            <h3 class="text-2xl font-black text-slate-800 dark:text-white mt-1">{{ $totalPegawai }}</h3>
        </div>
    </div>

    <!-- Card Kebutuhan Posisi -->
    <div class="bg-white dark:bg-slate-800/80 p-6 rounded-3xl border border-slate-100 dark:border-slate-700/50 shadow-sm flex items-center gap-4 hover:shadow-md transition-all duration-300 group">
        <div class="w-14 h-14 rounded-full bg-blue-50 dark:bg-blue-500/20 flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Kebutuhan Formasi</p>
            <h3 class="text-2xl font-black text-slate-800 dark:text-white mt-1">{{ $totalKebutuhan }} <span class="text-sm font-medium text-slate-500">Posisi</span></h3>
        </div>
    </div>

    <!-- Card Menunggu Validasi -->
    <div class="bg-white dark:bg-slate-800/80 p-6 rounded-3xl border border-slate-100 dark:border-slate-700/50 shadow-sm flex items-center gap-4 hover:shadow-md transition-all duration-300 group">
        <div class="w-14 h-14 rounded-full bg-amber-50 dark:bg-amber-500/20 flex items-center justify-center text-amber-500 dark:text-amber-400 group-hover:scale-110 transition-transform">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Menunggu Validasi</p>
            <h3 class="text-2xl font-black text-slate-800 dark:text-white mt-1">{{ $kandidatMenunggu }} <span class="text-sm font-medium text-slate-500">Kandidat</span></h3>
        </div>
    </div>

    <!-- Card Disetujui -->
    <div class="bg-white dark:bg-slate-800/80 p-6 rounded-3xl border border-slate-100 dark:border-slate-700/50 shadow-sm flex items-center gap-4 hover:shadow-md transition-all duration-300 group">
        <div class="w-14 h-14 rounded-full bg-emerald-50 dark:bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Siap Dieksekusi</p>
            <h3 class="text-2xl font-black text-slate-800 dark:text-white mt-1">{{ $kandidatDisetujui }} <span class="text-sm font-medium text-slate-500">Kandidat</span></h3>
        </div>
    </div>
</div>

<!-- Charts Grid Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    
    <!-- Chart 1: Kebutuhan Formasi Jabatan (Bar Chart) -->
    <div class="bg-white dark:bg-slate-800/80 p-6 rounded-3xl border border-slate-100 dark:border-slate-700/50 shadow-sm transition-all duration-300">
        <div class="flex justify-between items-center mb-4 px-2">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white transition-colors">Kuota Kebutuhan Formasi</h3>
            <span class="text-[10px] bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold px-2 py-0.5 rounded-md uppercase tracking-wider">Jabatan Terbuka</span>
        </div>
        <div id="chart-formasi" class="w-full"></div>
    </div>

    <!-- Chart 2: Persentase Status Nominasi SPK (Donut Chart) -->
    <div class="bg-white dark:bg-slate-800/80 p-6 rounded-3xl border border-slate-100 dark:border-slate-700/50 shadow-sm transition-all duration-300">
        <div class="flex justify-between items-center mb-4 px-2">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white transition-colors">Persentase Status Nominasi</h3>
            <span class="text-[10px] bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold px-2 py-0.5 rounded-md uppercase tracking-wider">Hasil SPK</span>
        </div>
        <div id="chart-nominasi" class="w-full flex items-center justify-center min-h-[320px]"></div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Informasi Sistem & Peringatan -->
    <div class="lg:col-span-2 space-y-6">
        @if($pegawaiBelumLengkap > 0)
        <div class="bg-rose-50 dark:bg-rose-500/10 p-6 rounded-3xl border border-rose-200 dark:border-rose-500/30 flex items-start gap-4">
            <div class="p-2 bg-rose-100 dark:bg-rose-500/20 rounded-xl text-rose-600 dark:text-rose-400 mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-rose-800 dark:text-rose-300 text-lg">Perhatian! Ada {{ $pegawaiBelumLengkap }} Pegawai Belum Dinilai</h3>
                <p class="text-rose-700 dark:text-rose-400 text-sm mt-1 leading-relaxed">Terdapat pegawai yang data Arsip Objektif atau nilai Observasi Subjektifnya masih kosong. Pegawai ini tidak akan bisa diikutsertakan dalam kalkulasi rotasi sebelum datanya dilengkapi.</p>
                @if(Auth::user()->role === 'Admin' || Auth::user()->role === 'Atasan')
                <div class="mt-3">
                    <a href="{{ route('spk.proses') }}" class="text-sm font-bold text-rose-600 dark:text-rose-400 hover:underline">Cek siapa saja &rarr;</a>
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="bg-white dark:bg-slate-800/80 p-8 rounded-3xl border border-slate-100 dark:border-slate-700/50 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-50 dark:bg-slate-700 rounded-full blur-3xl opacity-50 group-hover:bg-indigo-100 transition-colors"></div>
            
            <div class="relative z-10">
                <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Sistem Pendukung Keputusan (SPK)
                </h2>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
                    Sistem ini dibangun menggunakan metode <strong>Profile Matching</strong>. Metode cerdas ini bekerja dengan cara membandingkan kompetensi masing-masing pegawai (profil riil) dengan kompetensi ideal yang dibutuhkan (target profil jabatan).
                </p>
                <div class="flex flex-wrap gap-2 mt-6">
                    <span class="px-3 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-semibold rounded-full border border-slate-200 dark:border-slate-600">Pemetaan Gap</span>
                    <span class="px-3 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-semibold rounded-full border border-slate-200 dark:border-slate-600">Core Factor (60%)</span>
                    <span class="px-3 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-semibold rounded-full border border-slate-200 dark:border-slate-600">Secondary Factor (40%)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Papan Formasi Kosong -->
    <div class="bg-indigo-600 dark:bg-indigo-700 p-8 rounded-3xl text-white shadow-xl shadow-indigo-200 dark:shadow-indigo-900/50 relative overflow-hidden h-full flex flex-col justify-between">
        <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-bl-full"></div>
        <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-indigo-500/50 rounded-full blur-xl"></div>
        
        <div class="relative z-10">
            <h3 class="text-lg font-bold mb-1">Bursa Rotasi Terbuka</h3>
            <p class="text-indigo-200 text-sm mb-6">Daftar jabatan yang saat ini membutuhkan kandidat</p>

            @if($jabatanKosong->isEmpty())
            <div class="bg-indigo-800/50 p-6 rounded-2xl text-center border border-indigo-500/30">
                <p class="text-indigo-200 text-sm">Saat ini tidak ada jabatan yang sedang kosong atau membutuhkan rotasi pegawai.</p>
            </div>
            @else
            <ul class="space-y-3">
                @foreach($jabatanKosong as $jb)
                <li class="bg-white/10 hover:bg-white/20 transition-colors p-4 rounded-2xl border border-white/10 flex justify-between items-center backdrop-blur-sm">
                    <div>
                        <p class="font-bold text-white">{{ $jb->nama_jabatan }}</p>
                    </div>
                    <div class="flex flex-col items-end text-sm">
                        <span class="text-indigo-200 font-medium">Butuh</span>
                        <span class="font-black text-xl text-yellow-300">{{ $jb->kuota_kosong }}</span>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
            
            @if(Auth::user()->role === 'Admin')
            <div class="mt-6">
                <a href="{{ route('spk.proses') }}" class="block w-full py-3 px-4 bg-white text-indigo-700 text-center font-bold rounded-xl shadow-sm hover:bg-indigo-50 transition-colors">
                    Mulai Nominasi Rotasi
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- ApexCharts Script Integration -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Detect current dark mode state
        let isDark = document.documentElement.classList.contains('dark');
        
        // Colors & Theme Config
        const getChartTheme = (dark) => ({
            mode: dark ? 'dark' : 'light',
            palette: 'palette1',
            monochrome: {
                enabled: false
            }
        });

        // 1. DATA FOR BAR CHART (Formasi Terbuka)
        const formasiCategories = [
            @foreach($jabatanKosong as $jb)
                "{{ $jb->nama_jabatan }}",
            @endforeach
        ];
        const formasiData = [
            @foreach($jabatanKosong as $jb)
                {{ $jb->kuota_kosong }},
            @endforeach
        ];

        // Bar Chart Options
        const optionsFormasi = {
            chart: {
                type: 'bar',
                height: 320,
                toolbar: { show: false },
                background: 'transparent',
                fontFamily: 'Plus Jakarta Sans, sans-serif'
            },
            series: [{
                name: 'Kebutuhan Kuota',
                data: formasiData
            }],
            colors: ['#6366f1'], // Indigo-500
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    horizontal: false,
                    columnWidth: '40%',
                    dataLabels: { position: 'top' }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return val + " Orang";
                },
                offsetY: -22,
                style: {
                    fontSize: '11px',
                    fontWeight: 'bold',
                    colors: [isDark ? '#e2e8f0' : '#475569']
                }
            },
            stroke: { show: false },
            grid: {
                borderColor: isDark ? '#334155' : '#f1f5f9',
                strokeDashArray: 4,
                padding: { left: 10, right: 10, bottom: 0 }
            },
            xaxis: {
                categories: formasiCategories,
                labels: {
                    style: {
                        colors: isDark ? '#94a3b8' : '#64748b',
                        fontSize: '11px',
                        fontWeight: 500
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                title: {
                    text: 'Jumlah Kuota (Orang)',
                    style: {
                        color: isDark ? '#94a3b8' : '#64748b',
                        fontSize: '11px',
                        fontWeight: 500
                    }
                },
                labels: {
                    style: {
                        colors: isDark ? '#94a3b8' : '#64748b',
                        fontSize: '11px'
                    }
                },
                min: 0,
                forceNiceScale: true
            },
            tooltip: {
                theme: isDark ? 'dark' : 'light',
                y: {
                    formatter: function(val) { return val + " Orang" }
                }
            },
            theme: getChartTheme(isDark)
        };

        const chartFormasi = new ApexCharts(document.querySelector("#chart-formasi"), optionsFormasi);
        chartFormasi.render();


        // 2. DATA FOR DONUT CHART (Status Nominasi Rotasi)
        const menunggu = {{ $kandidatMenunggu }};
        const disetujui = {{ $kandidatDisetujui }};
        const ditolak = {{ $kandidatDitolak }};
        
        // Donut Chart Options
        const optionsNominasi = {
            chart: {
                type: 'donut',
                height: 320,
                background: 'transparent',
                fontFamily: 'Plus Jakarta Sans, sans-serif'
            },
            series: [disetujui, menunggu, ditolak],
            labels: ['Siap Dieksekusi (Disetujui)', 'Menunggu Validasi', 'Ditolak Pimpinan'],
            colors: ['#10b981', '#f59e0b', '#ef4444'], // Emerald-500, Amber-500, Red-500
            stroke: {
                show: true,
                width: 2,
                colors: [isDark ? '#1e293b' : '#ffffff']
            },
            dataLabels: { enabled: false },
            legend: {
                position: 'bottom',
                fontSize: '11px',
                fontWeight: 600,
                labels: {
                    colors: isDark ? '#e2e8f0' : '#475569'
                },
                markers: { radius: 12, width: 10, height: 10 }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '72%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '13px',
                                fontWeight: 600,
                                color: isDark ? '#94a3b8' : '#64748b',
                                offsetY: -8
                            },
                            value: {
                                show: true,
                                fontSize: '24px',
                                fontWeight: 800,
                                color: isDark ? '#ffffff' : '#1e293b',
                                offsetY: 8,
                                formatter: function(val) { return val }
                            },
                            total: {
                                show: true,
                                label: 'Total Nominasi',
                                color: isDark ? '#94a3b8' : '#64748b',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            },
            tooltip: {
                theme: isDark ? 'dark' : 'light'
            },
            theme: getChartTheme(isDark)
        };

        const chartNominasi = new ApexCharts(document.querySelector("#chart-nominasi"), optionsNominasi);
        chartNominasi.render();


        // 3. THEME SYNCHRONIZATION WITH DARK MODE TOGGLE
        const themeBtn = document.getElementById('theme-toggle');
        if (themeBtn) {
            themeBtn.addEventListener('click', function() {
                // Wait slightly for documentElement class to update
                setTimeout(() => {
                    const darkNow = document.documentElement.classList.contains('dark');
                    
                    // Update chart 1 (Bar Chart) options dynamically
                    chartFormasi.updateOptions({
                        theme: getChartTheme(darkNow),
                        dataLabels: {
                            style: { colors: [darkNow ? '#e2e8f0' : '#475569'] }
                        },
                        grid: { borderColor: darkNow ? '#334155' : '#f1f5f9' },
                        xaxis: {
                            labels: { style: { colors: darkNow ? '#94a3b8' : '#64748b' } }
                        },
                        yaxis: {
                            title: { style: { color: darkNow ? '#94a3b8' : '#64748b' } },
                            labels: { style: { colors: darkNow ? '#94a3b8' : '#64748b' } }
                        },
                        tooltip: { theme: darkNow ? 'dark' : 'light' }
                    });

                    // Update chart 2 (Donut Chart) options dynamically
                    chartNominasi.updateOptions({
                        theme: getChartTheme(darkNow),
                        stroke: { colors: [darkNow ? '#1e293b' : '#ffffff'] },
                        legend: {
                            labels: { colors: darkNow ? '#e2e8f0' : '#475569' }
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    labels: {
                                        name: { color: darkNow ? '#94a3b8' : '#64748b' },
                                        value: { color: darkNow ? '#ffffff' : '#1e293b' },
                                        total: { color: darkNow ? '#94a3b8' : '#64748b' }
                                    }
                                }
                            }
                        },
                        tooltip: { theme: darkNow ? 'dark' : 'light' }
                    });
                }, 100);
            });
        }
    });
</script>
@endsection