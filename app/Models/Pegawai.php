<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'tb_pegawai';
    protected $fillable = ['nip', 'nama', 'pangkat', 'golongan', 'id_jabatan', 'tmt_jabatan', 'hukuman_disiplin'];

    protected $casts = [
        'tmt_jabatan' => 'date',
        'hukuman_disiplin' => 'boolean',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }

    public function arsip()
    {
        return $this->hasOne(Arsip::class, 'id_pegawai');
    }

    public function observasi()
    {
        return $this->hasOne(Observasi::class, 'id_pegawai');
    }
}