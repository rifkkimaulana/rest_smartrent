<?php

namespace App\Controllers\Api;

use App\Models\KategoriModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Kategori extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

        $kategoriModel = new KategoriModel();

        $result = $kategoriModel->orderBy('id', 'DESC')->findAll(10);

        if (!empty($result)) {
            $data = [
                'status' => true,
                'data' => $result
            ];
        } else {
            $data = [
                'status' => false,
                'message' => 'Tidak ada kategori'
            ];
        }
        return $this->respond($data);
    }
}
