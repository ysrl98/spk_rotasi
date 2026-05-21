<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'tb_jabatan'; // Tambahkan ini
    protected $fillable = ['nama_jabatan', 'kuota_kosong'];
}