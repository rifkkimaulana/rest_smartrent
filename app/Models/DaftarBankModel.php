<?php

namespace App\Models;

use CodeIgniter\Model;

class DaftarBankModel extends Model
{
    protected $table = 'tbl_daftar_bank';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_bank',
        'logo_bank'
    ];
}
