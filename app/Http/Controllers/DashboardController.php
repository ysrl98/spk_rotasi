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

        // Statistik Proses SPK (Hasil Rotasi)
        $kandidatMenunggu = \App\Models\HasilRotasi::where('status_validasi', 'Menunggu')->count();
        $kandidatDisetujui = \App\Models\HasilRotasi::where('status_validasi', 'Disetujui')->count();
        $kandidatDitolak = \App\Models\HasilRotasi::where('status_validasi', 'Ditolak')->count();
        
        // Cek pegawai yang datanya belum lengkap (Arsip/Observasi)
        $pegawaiBelumLengkap = \App\Models\Pegawai::whereDoesntHave('arsip')
            ->orWhereDoesntHave('observasi')
            ->count();

        return view('dashboard.index', compact(
            'role', 
            'totalPegawai', 
            'totalJabatan', 
            'totalKebutuhan',
            'jabatanKosong',
            'kandidatMenunggu',
            'kandidatDisetujui',
            'kandidatDitolak',
            'pegawaiBelumLengkap'
        ));
    }
}