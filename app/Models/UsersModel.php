<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'tbl_users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_lengkap',
        'username',
        'password',
        'level_user',
        'gambar',
        'telpon',
        'alamat_email',
        'created_at'
    ];

    public function insertData($data)
    {
        return $this->insert($data);
    }

    public function updateId($id, $data)
    {
        $this->set($data)->where('id', $id)->update();
    }

    public function deleteId($id)
    {
        return $this->where('id', $id)->delete();
    }
}
