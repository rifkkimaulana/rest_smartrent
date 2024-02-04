<?php

namespace App\Controllers\Api\Pengaturan;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\WablasModel;

class Wablas extends ResourceController
{
    use ResponseTrait;

    public function create()
    {
        $WablasModel = new WablasModel();

        $data = [
            'domain_api' => $this->request->getVar('domain_api'),
            'token_api' => $this->request->getVar('token_api'),
        ];

        if ($WablasModel->update(1, $data)) {
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
        $WablasModel = new WablasModel();
        $data = $WablasModel->where('id', $id)->first();
        if ($data) {

            $data = [
                'status' => 200,
                'data' => [$data]
            ];
        }
        return $this->respond($data);
    }
}
