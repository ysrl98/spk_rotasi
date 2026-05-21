<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'tb_pegawai'; // Tambahkan ini
    protected $fillable = ['nip', 'nama', 'pangkat', 'golongan', 'id_jabatan'];

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