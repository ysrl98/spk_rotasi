<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\HasilRotasi;
use App\Services\ProfileMatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Ambil daftar jabatan yang sudah di-setup Target Profil-nya
        $jabatanTersedia = \App\Models\TargetProfil::with('jabatan')->select('id_jabatan')->distinct()->get();

        return view('spk.proses', compact('pegawais', 'dataBelumLengkap', 'jabatanTersedia'));
    }

    /**
     * Mengeksekusi algoritma Profile Matching
     */
    public function hitung(Request $request)
    {
        $request->validate([
            'nominasi_ids' => 'required|array|min:1',
            'jabatan_ids' => 'required|array|min:1',
        ], [
            'nominasi_ids.required' => 'Pilih minimal satu kandidat yang masuk dalam nominasi bursa rotasi!',
            'jabatan_ids.required' => 'Pilih minimal satu jabatan tujuan yang sedang dibuka/kosong!',
        ]);

        try {
            DB::beginTransaction();

            // Mereset (Hapus) seluruh hasil rotasi dan data validasi sebelumnya
            HasilRotasi::query()->delete();

            // Ambil kandidat yang dinominasikan dan nilainya sudah lengkap (ada di arsip dan observasi)
            $pegawais = Pegawai::whereIn('id', $request->nominasi_ids)
                               ->whereHas('arsip')
                               ->whereHas('observasi')
                               ->get();
            
            if ($pegawais->isEmpty()) {
                return redirect()->back()->with('error', 'Kandidat yang dinominasikan belum melengkapi data penilaian secara penuh.');
            }
            
            // Gunakan daftar jabatan yang DIPILIH oleh Admin
            $jabatanIds = $request->jabatan_ids;

            // Hitung kecocokan tiap pegawai terhadap tiap jabatan
            foreach ($pegawais as $pegawai) {
                foreach ($jabatanIds as $id_jabatan) {
                    // Pengecualian: Jangan hitung rotasi ke jabatan yang sedang diduduki saat ini
                    if ($pegawai->id_jabatan == $id_jabatan) {
                        continue; 
                    }

                    $this->profileMatchingService->hitung($pegawai->id, $id_jabatan);
                }
            }

            DB::commit();
            return redirect()->route('spk.hasil')->with('success', 'Perhitungan SPK Profile Matching berhasil diselesaikan!');
        } catch (\Exception $e) {
            DB::rollBack();
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

    /**
     * Mengeksekusi mutasi secara permanen setelah disetujui Pimpinan
     */
    public function eksekusi()
    {
        try {
            DB::beginTransaction();
            
            // Hanya ambil yang disetujui
            $hasilDisetujui = HasilRotasi::where('status_validasi', 'Disetujui')->get();

            if ($hasilDisetujui->isEmpty()) {
                return redirect()->back()->with('error', 'Eksekusi dibatalkan: Belum ada kandidat rotasi yang disetujui oleh Pimpinan.');
            }

            foreach ($hasilDisetujui as $hasil) {
                $pegawai = Pegawai::find($hasil->id_pegawai);
                if (!$pegawai) continue;
                
                $jabatanLamaId = $pegawai->id_jabatan;
                $jabatanBaruId = $hasil->id_jabatan_tujuan;

                // 1. Update kuota jabatan lama (bertambah karena ditinggalkan)
                if ($jabatanLamaId) {
                    $jabatanLama = \App\Models\Jabatan::find($jabatanLamaId);
                    if ($jabatanLama) {
                        $jabatanLama->increment('kuota_kosong');
                    }
                }

                // 2. Update kuota jabatan baru (berkurang karena terisi)
                $jabatanBaru = \App\Models\Jabatan::find($jabatanBaruId);
                if ($jabatanBaru) {
                    // Mencegah kuota minus
                    if ($jabatanBaru->kuota_kosong > 0) {
                        $jabatanBaru->decrement('kuota_kosong');
                    }
                }

                // 3. Pindahkan pegawai ke jabatan baru
                $pegawai->update(['id_jabatan' => $jabatanBaruId]);
            }

            // 4. Bersihkan data spk untuk menutup siklus periode rotasi
            HasilRotasi::query()->delete();

            DB::commit();
            return redirect()->route('spk.hasil')->with('success', 'Mutasi berhasil dieksekusi secara permanen! Data pegawai dan kuota jabatan telah diperbarui secara otomatis.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengeksekusi mutasi: ' . $e->getMessage());
        }
    }
}
