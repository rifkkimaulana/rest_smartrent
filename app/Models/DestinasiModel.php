<?php

namespace App\Models;

use CodeIgniter\Model;

class DestinasiModel extends Model
{
    protected $table = 'tbl_destinasi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_destinasi',
        'deskripsi',
        'lokasi',
        'gambar_destinasi',
        'created_at'
    ];
}
