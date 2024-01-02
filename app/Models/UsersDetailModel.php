<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersDetailModel extends Model
{
    protected $table = 'tbl_user_detail';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = [
        'user_id',
        'nik',
        'nama_ktp',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat_ktp'
    ];
}
