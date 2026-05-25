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
        // Persentase diambil dari config
        $persenCore = config('spk.bobot_core_factor', 0.60);
        $persenSecondary = config('spk.bobot_secondary_factor', 0.40);
        
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
