<?php

namespace App\Models;

use CodeIgniter\Model;

class BankModel extends Model
{
    protected $table = 'tbl_bank';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'daftar_bank_id',
        'nama_lengkap',
        'nomor_rekening'
    ];
}
