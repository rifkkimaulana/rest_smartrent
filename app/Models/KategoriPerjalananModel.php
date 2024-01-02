<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriPerjalananModel extends Model
{
    protected $table = 'tbl_kategori_perjalanan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_kategori'
    ];
}
