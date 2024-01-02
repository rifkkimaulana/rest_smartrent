<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'tbl_transaksi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'no_transaksi',
        'user_id',
        'tanggal_penyewaan',
        'tanggal_pengembalian',
        'total_harga',
        'status_transaksi'
    ];
}
