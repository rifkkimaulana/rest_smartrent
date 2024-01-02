<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiDuitkuModel extends Model
{
    protected $table = 'tbl_transaksi_duitku';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'reference',
        'no_transaksi',
        'user_id',
        'jenis_transaksi',
        'status',
        'created_at',
        'channel',
        'pembayaran'
    ];
}
