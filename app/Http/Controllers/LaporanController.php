<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilRotasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function cetakSK()
    {
        // Ambil semua data mutasi yang telah disetujui Pimpinan
        $hasilRotasi = HasilRotasi::with(['pegawai', 'pegawai.jabatan', 'jabatan'])
            ->where('status_validasi', 'Disetujui')
            ->get();

        if ($hasilRotasi->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data rotasi yang disetujui untuk dicetak SK.');
        }

        // Setup data untuk template PDF
        $data = [
            'tanggal_sk' => Carbon::now()->translatedFormat('d F Y'),
            'hasilRotasi' => $hasilRotasi
        ];

        // Generate PDF menggunakan template laporan/sk_pdf.blade.php
        $pdf = Pdf::loadView('laporan.sk_pdf', $data);
        
        // Atur ukuran kertas ke A4 (Folio/F4 tidak didukung native by name, A4 lazim)
        $pdf->setPaper('a4', 'portrait');

        // Kembalikan stream PDF agar bisa di-preview di browser (opsi: download() untuk unduh langsung)
        return $pdf->stream('SK_Mutasi_Kejari_Banjarmasin.pdf');
    }
}
