<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\LogModel;

class Riwayat extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $riwayatModel = new LogModel();

        $data = $riwayatModel->orderBy('id', 'DESC')->findAll();
        if ($data) {
            $response = [
                'status' => 200,
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 404,
                'data' => [
                    'messages' => 'Pengguna Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($response);
    }

    public function create()
    {
        $riwayatModel = new LogModel();

        $data = [
            'user_id' => $this->request->getVar('user_id'),
            'aktivitas' => $this->request->getVar('aktivitas'),
            'created_at' => $this->request->getVar('created_at'),
        ];

        if ($riwayatModel->insert($data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Riwayat Berhasil ditambahkan!'
                ]
            ];
        } else {
            $data = [
                'status'   => 400,
                'data' => [
                    'messages' => 'Riwayat Gagal ditambahkan!'
                ]
            ];
        }

        return $this->respond($data);
    }

    public function delete($id = null)
    {
        $UsersModel = new LogModel();
        $data = $UsersModel->where('id', $id)->first();

        if ($data) {
            if ($UsersModel->delete($id)) {
                $data = [
                    'status'   => 204,
                    'success' => [
                        'messages' => 'Data Riwayat berhasil dihapus.'
                    ]
                ];
            } else {
                $data = [
                    'status'   => 500,
                    'error' => [
                        'messages' => 'Kesalahan sistem tidak dapat menghapus user terpilih.'
                    ]
                ];
            }
        } else {
            $data = [
                'status'   => 404,
                'error' => [
                    'messages' => 'Data Riwayat Tidak Tersedia.'
                ]
            ];
        }
        return $this->respond($data);
    }
}
