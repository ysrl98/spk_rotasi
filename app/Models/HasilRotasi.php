<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilRotasi extends Model
{
    use HasFactory;

    protected $table = 'tb_hasil_rotasi';
    protected $guarded = [];

    protected $casts = [
        'detail_kalkulasi' => 'array',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan_tujuan');
    }
}