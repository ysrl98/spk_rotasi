<?php

namespace App\Services;

use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\TargetProfil;
use App\Models\BobotGap;
use App\Models\Arsip;
use App\Models\Observasi;
use App\Models\HasilRotasi;

class ProfileMatchingService
{
    /**
     * Hitung SPK untuk satu pegawai terhadap satu jabatan tertentu
     */
    public function hitung($id_pegawai, $id_jabatan)
    {
        $pegawai = Pegawai::findOrFail($id_pegawai);
        $jabatan = Jabatan::findOrFail($id_jabatan);

        // Ambil data nilai riil
        $arsip = Arsip::where('id_pegawai', $id_pegawai)->first();
        $observasi = Observasi::where('id_pegawai', $id_pegawai)->first();

        // Jika data penilaian belum lengkap, bisa lempar exception atau return nilai 0
        if (!$arsip || !$observasi) {
            return [
                'status' => 'error',
                'message' => 'Data Arsip atau Observasi belum lengkap untuk pegawai ini.'
            ];
        }

        // Ambil target profil untuk jabatan ini
        $targets = TargetProfil::with('kriteria')->where('id_jabatan', $id_jabatan)->get();

        if ($targets->isEmpty()) {
            return [
                'status' => 'error',
                'message' => 'Target profil untuk jabatan ini belum diatur.'
            ];
        }

        $coreFactors = [];
        $secondaryFactors = [];

        foreach ($targets as $target) {
            $kriteria = $target->kriteria;
            
            // 1. Ekstrak Nilai Riil (Mapping Dinamis ke Kolom Statis)
            $nilai_riil = $this->getNilaiRiilPegawai($kriteria, $arsip, $observasi);
            
            // 2. Hitung GAP
            $gap = $nilai_riil - $target->nilai_target;

            // 3. Konversi GAP ke Bobot
            $bobot = $this->getBobotGap($gap);

            // 4. Kelompokkan ke CF atau SF
            if (strtolower($target->tipe_faktor) == 'core' || strtolower($target->tipe_faktor) == 'core factor') {
                $coreFactors[] = $bobot;
            } else {
                $secondaryFactors[] = $bobot;
            }
        }

        // 5. Hitung NCF (Nilai Core Factor) dan NSF (Nilai Secondary Factor)
        $ncf = count($coreFactors) > 0 ? array_sum($coreFactors) / count($coreFactors) : 0;
        $nsf = count($secondaryFactors) > 0 ? array_sum($secondaryFactors) / count($secondaryFactors) : 0;

        // 6. Hitung Nilai Akhir (Total Value)
        // Persentase: 60% Core, 40% Secondary
        $persenCore = 0.60;
        $persenSecondary = 0.40;
        
        $nilai_total = ($persenCore * $ncf) + ($persenSecondary * $nsf);

        // 7. Simpan ke database Hasil Rotasi
        $hasil = HasilRotasi::updateOrCreate(
            ['id_pegawai' => $id_pegawai, 'id_jabatan_tujuan' => $id_jabatan],
            [
                'nilai_total' => $nilai_total,
                'status_validasi' => 'Menunggu'
            ]
        );

        return [
            'status' => 'success',
            'data' => [
                'pegawai' => $pegawai->nama_pegawai,
                'jabatan' => $jabatan->nama_jabatan,
                'ncf' => $ncf,
                'nsf' => $nsf,
                'nilai_total' => $nilai_total,
                'hasil_id' => $hasil->id
            ]
        ];
    }

    /**
     * Helper untuk memetakan nama kriteria ke kolom database di tb_arsip dan tb_observasi
     */
    private function getNilaiRiilPegawai($kriteria, $arsip, $observasi)
    {
        $nama = strtolower($kriteria->nama_kriteria);
        
        // Cek tabel Arsip
        if (strpos($nama, 'pendidikan') !== false) return $arsip->nilai_pendidikan;
        if (strpos($nama, 'masa kerja') !== false) return $arsip->nilai_masa_kerja;
        if (strpos($nama, 'prestasi') !== false || strpos($nama, 'skp') !== false) return $arsip->nilai_skp;
        if (strpos($nama, 'disiplin') !== false) return $arsip->nilai_disiplin;
        if (strpos($nama, 'kemampuan') !== false) return $arsip->nilai_skp; // fallback
        
        // Cek tabel Observasi
        if (strpos($nama, 'inisiatif') !== false) return $observasi->nilai_inisiatif;
        if (strpos($nama, 'kerja sama') !== false || strpos($nama, 'kerjasama') !== false) return $observasi->nilai_kerjasama;
        
        // Default jika tidak ditemukan mapping yang pas (asumsi nilai rata-rata 3)
        return 3;
    }

    /**
     * Helper untuk mengambil bobot berdasarkan selisih GAP
     */
    private function getBobotGap($gap)
    {
        // Cari di database
        $bobotGap = BobotGap::where('selisih', $gap)->first();
        if ($bobotGap) {
            return $bobotGap->bobot;
        }

        // Fallback jika tidak ada di DB (hardcode standar Profile Matching)
        $standar = [
            '0' => 5,
            '1' => 4.5,
            '-1' => 4,
            '2' => 3.5,
            '-2' => 3,
            '3' => 2.5,
            '-3' => 2,
            '4' => 1.5,
            '-4' => 1
        ];

        return $standar[(string)$gap] ?? 0; // Jika gap diluar batas, beri nilai 0
    }
}
