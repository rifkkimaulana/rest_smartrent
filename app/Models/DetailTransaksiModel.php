<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table = 'tbl_detail_transaksi';
    protected $primaryKey = 'id_detail_transaksi';
    protected $allowedFields = [
        'no_transaksi',
        'inventaris_id',
        'harga_sewa',
        'jumlah_barang',
        'durasi_sewa'
    ];
}
