<?php

namespace App\Controllers\Api\Pengaturan;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\DuitkuModel;

class Duitku extends ResourceController
{
    use ResponseTrait;

    public function create()
    {
        $DuitkuModel = new DuitkuModel();

        $data = [
            'environment' => $this->request->getVar('environment'),
            'merchant_code' => $this->request->getVar('merchant_code'),
            'apikey_duitku' => $this->request->getVar('apikey_duitku'),
        ];

        if ($DuitkuModel->update(1, $data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Apikey Berhasil diubah!'
                ]
            ];
        } else {
            $data = [
                'status'   => 400,
                'data' => [
                    'messages' => 'Apikey Gagal diubah!'
                ]
            ];
        }

        return $this->respond($data);
    }

    public function show($id = null)
    {
        $DuitkuModel = new DuitkuModel();
        $data = $DuitkuModel->where('id', $id)->first();
        if ($data) {

            $data = [
                'status' => 200,
                'data' => [$data]
            ];
        }
        return $this->respond($data);
    }
}
