<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarisModel extends Model
{
    protected $table = 'tbl_inventaris';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_barang',
        'kategori_id',
        'deskripsi',
        'harga_sewa',
        'stok',
        'gambar',
        'create_at',
        'status',
        'informasi_tambahan',
        'durasi_sewa'
    ];
}
