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

    public function fetch_data($limit, $start, $search, $kategori)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');

        if (!empty($search)) {
            $builder->like('nama_barang', $search);
        }

        if (!empty($kategori)) {
            $builder->where('kategori_id', $kategori);
        }

        $builder->limit($limit, $start);
        $builder->orderBy('id', 'ASC');

        return $builder->get();
    }
}
