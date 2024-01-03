<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama',
        'harga',
        'deskripsi',
        'img',
        'kategori'
    ];

    public function fetch_data($limit, $start, $search, $kategori)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');

        if (!empty($search)) {
            $builder->like('nama', $search);
        }

        if (!empty($kategori)) {
            $builder->where('kategori', $kategori);
        }

        $builder->limit($limit, $start);
        $builder->orderBy('id', 'ASC');

        return $builder->get();
    }
}
