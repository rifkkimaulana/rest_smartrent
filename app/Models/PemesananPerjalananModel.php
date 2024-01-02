<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananPerjalananModel extends Model
{
    protected $table = 'tbl_pemesanan_perjalanan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'no_transaksi',
        'user_id',
        'paket_id',
        'jumlah_peserta',
        'total_pembayaran',
        'tanggal_pemesanan',
        'status_pembayaran'
    ];
}
