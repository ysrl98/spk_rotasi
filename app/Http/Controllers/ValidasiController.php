<?php

namespace App\Http\Controllers;

use App\Models\HasilRotasi;
use Illuminate\Http\Request;

class ValidasiController extends Controller
{
    public function index()
    {
        // Mengambil semua hasil dan mengelompokkannya berdasarkan id_jabatan_tujuan
        $hasil = HasilRotasi::with(['jabatan'])->get();
        $grupJabatan = $hasil->groupBy('id_jabatan_tujuan');

        return view('validasi.index', compact('grupJabatan'));
    }

    public function show($id_jabatan)
    {
        $jabatan = \App\Models\Jabatan::findOrFail($id_jabatan);
        
        $kandidat = HasilRotasi::with(['pegawai'])
                    ->where('id_jabatan_tujuan', $id_jabatan)
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

            $hasil->update(['status_validasi' => 'Disetujui']);
            return redirect()->back()->with('success', 'Rekomendasi rotasi disetujui!');
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
