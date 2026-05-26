<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        
        // Statistik Umum
        $totalPegawai = \App\Models\Pegawai::count();
        $totalJabatan = \App\Models\Jabatan::count();
        
        // Statistik Kebutuhan Jabatan (Kuota Kosong)
        $totalKebutuhan = \App\Models\Jabatan::sum('kuota_kosong');
        $jabatanKosong = \App\Models\Jabatan::where('kuota_kosong', '>', 0)->get();

        // Statistik Proses SPK (Hasil Rotasi) - Hanya Periode Aktif
        $latestPeriode = \App\Models\HasilRotasi::where('status_validasi', '!=', 'Dieksekusi')
                                                ->orderBy('id', 'desc')
                                                ->value('periode_aktif');
                                                
        $kandidatMenunggu = \App\Models\HasilRotasi::where('periode_aktif', $latestPeriode)->where('status_validasi', 'Menunggu')->count();
        $kandidatDisetujui = \App\Models\HasilRotasi::where('periode_aktif', $latestPeriode)->where('status_validasi', 'Disetujui')->count();
        $kandidatDitolak = \App\Models\HasilRotasi::where('periode_aktif', $latestPeriode)->where('status_validasi', 'like', 'Ditolak%')->count();
        
        // Cek pegawai yang datanya belum lengkap (Arsip/Observasi)
        $pegawaiBelumLengkap = \App\Models\Pegawai::whereDoesntHave('arsip')
            ->orWhereDoesntHave('observasi')
            ->count();
            
        // ==========================================
        // 1. Data Alarm Jatuh Tempo (Tenure Warning)
        // Pegawai yang sudah > 4 tahun (48 bulan) di posisi yang sama
        // ==========================================
        $batasTahun = \Carbon\Carbon::now()->subYears(4);
        $pegawaiOverdue = \App\Models\Pegawai::with('jabatan')
            ->whereDate('tmt_jabatan', '<=', $batasTahun)
            ->orderBy('tmt_jabatan', 'asc')
            ->get();

        // ==========================================
        // 2. Data Grafik Analitik (Chart.js)
        // ==========================================
        // Data Grafik: Distribusi Pegawai per Jabatan
        $sebaranPegawai = \App\Models\Pegawai::select('id_jabatan', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('id_jabatan')
            ->with('jabatan')
            ->get();
            
        $labelDivisi = [];
        $dataDivisi = [];
        $warnaDivisi = ['#6366f1', '#14b8a6', '#f59e0b', '#ec4899', '#8b5cf6', '#3b82f6']; // Warna tailwind: indigo, teal, amber, pink, violet, blue
        
        foreach ($sebaranPegawai as $idx => $sp) {
            $labelDivisi[] = $sp->jabatan->nama_jabatan ?? 'Belum Ada';
            $dataDivisi[] = $sp->total;
        }

        return view('dashboard.index', compact(
            'role', 
            'totalPegawai', 
            'totalJabatan', 
            'totalKebutuhan',
            'jabatanKosong',
            'kandidatMenunggu',
            'kandidatDisetujui',
            'kandidatDitolak',
            'pegawaiBelumLengkap',
            'pegawaiOverdue',
            'labelDivisi',
            'dataDivisi',
            'warnaDivisi'
        ));
    }
}