<?php

namespace App\Models;

use CodeIgniter\Model;

class AlamatModel extends Model
{
    protected $table = 'tbl_alamat';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'alamat_lengkap'
    ];
}
