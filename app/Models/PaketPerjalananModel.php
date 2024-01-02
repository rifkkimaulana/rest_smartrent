<?php

namespace App\Models;

use CodeIgniter\Model;

class PaketPerjalananModel extends Model
{
    protected $table = 'tbl_paket_perjalanan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kategori_id',
        'nama_paket',
        'deskripsi',
        'harga_paket',
        'kuota_peserta',
        'gambar_paket',
        'created_at'
    ];
}
