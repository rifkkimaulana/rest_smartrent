<?php

namespace App\Models;

use CodeIgniter\Model;

class RelasiPaketDestinasiModel extends Model
{
    protected $table = 'tbl_relasi_paket_destinasi';
    protected $primaryKey = 'id_relasi';
    protected $allowedFields = [
        'id_paket',
        'id_destinasi'
    ];
}
