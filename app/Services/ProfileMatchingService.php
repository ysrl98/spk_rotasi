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
     * Menerima instance model dan collection untuk menghindari N+1 query
     */
    public function hitung($pegawai, $jabatan, $targets, $bobotGaps, $periodeAktif)
    {
        // Gunakan relasi yang sudah di-eager load
        $arsip = $pegawai->arsip;
        $observasi = $pegawai->observasi;

        // Jika data penilaian belum lengkap, bisa lempar exception atau return nilai 0
        if (!$arsip || !$observasi) {
            return [
                'status' => 'error',
                'message' => 'Data Arsip atau Observasi belum lengkap untuk pegawai ini.'
            ];
        }

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

            // 3. Konversi GAP ke Bobot (Lempar $bobotGaps collection)
            $bobot = $this->getBobotGap($gap, $bobotGaps);

            // 4. Kelompokkan ke CF atau SF (Strict Validation === 'Core')
            if ($target->tipe_faktor === 'Core') {
                $coreFactors[] = $bobot;
            } else {
                $secondaryFactors[] = $bobot;
            }
        }

        // 5. Hitung NCF (Nilai Core Factor) dan NSF (Nilai Secondary Factor)
        $ncf = count($coreFactors) > 0 ? array_sum($coreFactors) / count($coreFactors) : 0;
        $nsf = count($secondaryFactors) > 0 ? array_sum($secondaryFactors) / count($secondaryFactors) : 0;

        // 6. Hitung Nilai Akhir (Total Value)
        // Persentase diambil dari config
        $persenCore = config('spk.bobot_core_factor', 0.60);
        $persenSecondary = config('spk.bobot_secondary_factor', 0.40);
        
        $nilai_total = ($persenCore * $ncf) + ($persenSecondary * $nsf);

        // 7. Simpan ke database Hasil Rotasi beserta periode aktif
        $hasil = HasilRotasi::updateOrCreate(
            ['id_pegawai' => $pegawai->id, 'id_jabatan_tujuan' => $jabatan->id, 'periode_aktif' => $periodeAktif],
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
        // Gunakan pemetaan kolom langsung dari tabel tb_kriteria (sumber_nilai)
        if (!empty($kriteria->sumber_nilai)) {
            $sumber = explode('.', $kriteria->sumber_nilai);
            if (count($sumber) === 2) {
                $tabel = $sumber[0];
                $kolom = $sumber[1];

                if ($tabel === 'arsip' && $arsip) {
                    return $arsip->{$kolom} ?? 3;
                }
                
                if ($tabel === 'observasi' && $observasi) {
                    return $observasi->{$kolom} ?? 3;
                }
            }
        }

        // Default jika terjadi kesalahan mapping
        return 3;
    }

    /**
     * Helper untuk mengambil bobot berdasarkan selisih GAP (No Hardcode Fallback)
     */
    private function getBobotGap($gap, $bobotGaps)
    {
        if (!isset($bobotGaps[$gap])) {
            throw new \Exception("FATAL: Konfigurasi Bobot GAP tidak ditemukan untuk selisih [{$gap}]. Silakan lengkapi Master Data Bobot Gap.");
        }

        return $bobotGaps[$gap]->bobot;
    }
}
