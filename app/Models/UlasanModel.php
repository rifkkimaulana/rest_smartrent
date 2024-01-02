<?php

namespace App\Models;

use CodeIgniter\Model;

class UlasanModel extends Model
{
    protected $table = 'tbl_ulasan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_transaksi',
        'rating',
        'komentar',
        'created_at
          '
    ];
}
