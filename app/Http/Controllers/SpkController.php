<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\HasilRotasi;
use App\Services\ProfileMatchingService;
use Illuminate\Http\Request;

class SpkController extends Controller
{
    protected $profileMatchingService;

    public function __construct(ProfileMatchingService $profileMatchingService)
    {
        $this->profileMatchingService = $profileMatchingService;
    }

    /**
     * Menampilkan halaman persiapan sebelum perhitungan SPK
     */
    public function proses()
    {
        // Ambil semua pegawai beserta data arsip dan observasinya untuk dicek kesiapannya
        $pegawais = Pegawai::with(['arsip', 'observasi', 'jabatan'])->get();
        
        // Cek apakah ada pegawai yang datanya belum lengkap
        $dataBelumLengkap = $pegawais->filter(function ($pegawai) {
            return is_null($pegawai->arsip) || is_null($pegawai->observasi);
        })->count();

        return view('spk.proses', compact('pegawais', 'dataBelumLengkap'));
    }

    /**
     * Mengeksekusi algoritma Profile Matching
     */
    public function hitung()
    {
        try {
            // Ambil kandidat yang nilainya sudah lengkap (ada di arsip dan observasi)
            $pegawais = Pegawai::whereHas('arsip')->whereHas('observasi')->get();
            
            // Ambil daftar jabatan yang sudah memiliki target profil
            $jabatanIds = \App\Models\TargetProfil::select('id_jabatan')->distinct()->pluck('id_jabatan');

            // Hitung kecocokan tiap pegawai terhadap tiap jabatan
            foreach ($pegawais as $pegawai) {
                foreach ($jabatanIds as $id_jabatan) {
                    $this->profileMatchingService->hitung($pegawai->id, $id_jabatan);
                }
            }

            return redirect()->route('spk.hasil')->with('success', 'Perhitungan SPK Profile Matching berhasil diselesaikan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghitung SPK: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan hasil perankingan SPK
     */
    public function hasil()
    {
        // Mengambil hasil perhitungan dari database, diurutkan berdasarkan jabatan dan nilai total tertinggi
        $hasil = HasilRotasi::with(['pegawai', 'jabatan'])
                    ->orderBy('id_jabatan_tujuan')
                    ->orderByDesc('nilai_total')
                    ->get();

        // Mengelompokkan hasil berdasarkan jabatan
        $hasilPerJabatan = $hasil->groupBy(function($item) {
            return $item->jabatan->nama_jabatan ?? 'Jabatan Tidak Diketahui';
        });

        return view('spk.hasil', compact('hasilPerJabatan'));
    }
}
