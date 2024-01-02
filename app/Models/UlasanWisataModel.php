<?php

namespace App\Models;

use CodeIgniter\Model;

class UlasanWisataModel extends Model
{
    protected $table = 'tbl_ulasan_wisata';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'destinasi_id',
        'ulasan',
        'rating',
        'tanggal_ulasan'
    ];
}
