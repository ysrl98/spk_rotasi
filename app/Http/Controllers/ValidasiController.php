<?php

namespace App\Http\Controllers;

use App\Models\HasilRotasi;
use Illuminate\Http\Request;

class ValidasiController extends Controller
{
    public function index()
    {
        // Hanya mengambil hasil yang belum dieksekusi (Periode Berjalan)
        $hasil = HasilRotasi::with(['jabatan'])
                    ->where('status_validasi', '!=', 'Dieksekusi')
                    ->get();
        $grupJabatan = $hasil->groupBy('id_jabatan_tujuan');

        return view('validasi.index', compact('grupJabatan'));
    }

    public function show($id_jabatan)
    {
        $jabatan = \App\Models\Jabatan::findOrFail($id_jabatan);
        
        $kandidat = HasilRotasi::with(['pegawai'])
                    ->where('id_jabatan_tujuan', $id_jabatan)
                    ->where('status_validasi', '!=', 'Dieksekusi')
                    ->orderByDesc('nilai_total')
                    ->get();

        return view('validasi.show', compact('jabatan', 'kandidat'));
    }

    public function setuju($id)
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($id) {
            $hasil = HasilRotasi::with('jabatan')->lockForUpdate()->findOrFail($id);
            
            // Cek apakah kuota sudah terpenuhi
            $kuota = $hasil->jabatan->kuota_kosong ?? 1;
            $sudahDisetujui = HasilRotasi::where('id_jabatan_tujuan', $hasil->id_jabatan_tujuan)
                                         ->where('status_validasi', 'Disetujui')
                                         ->lockForUpdate()
                                         ->count();

            if ($sudahDisetujui >= $kuota) {
                return redirect()->back()->with('error', 'Gagal! Kuota untuk jabatan ini (' . $kuota . ' orang) sudah terpenuhi. Batalkan kandidat lain terlebih dahulu.');
            }

            // 1. Setujui kandidat ini
            $hasil->update(['status_validasi' => 'Disetujui']);
            
            // 2. Cross-Validation: Tolak otomatis rekomendasi ganda untuk pegawai ini di jabatan lain pada periode yang sama
            HasilRotasi::where('id_pegawai', $hasil->id_pegawai)
                       ->where('periode_aktif', $hasil->periode_aktif)
                       ->where('id', '!=', $id)
                       ->where('status_validasi', 'Menunggu')
                       ->update(['status_validasi' => 'Ditolak (Penempatan Ganda)']);

            return redirect()->back()->with('success', 'Rekomendasi rotasi disetujui, rekomendasi lain untuk pegawai ini otomatis ditolak!');
        });
    }

    public function tolak($id)
    {
        $hasil = HasilRotasi::findOrFail($id);
        $hasil->update(['status_validasi' => 'Ditolak']);
        return redirect()->back()->with('success', 'Rekomendasi rotasi ditolak.');
    }

    public function batal($id)
    {
        $hasil = HasilRotasi::findOrFail($id);
        $hasil->update(['status_validasi' => 'Menunggu']);
        return redirect()->back()->with('success', 'Validasi berhasil dibatalkan.');
    }
}
