<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class User extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $userModel = new UserModel();
        $data = [
            'status' => TRUE,
            'data' => $userModel->orderBy('id', 'DESC')->findAll()
        ];
        return $this->respond($data);
    }

    public function create()
    {
        try {
            $userModel = new UserModel();
            $data = [
                'nama_lengkap' => $this->request->getVar('nama_lengkap'),
                'username' => $this->request->getVar('username'),
                'password' => $this->request->getVar('password'),
                'email' => $this->request->getVar('email'),
                'user_level' => $this->request->getVar('user_level'),
                'user_foto' => $this->request->getVar('user_foto'),
            ];

            $userModel->insert($data);

            $response = [
                'status'   => 201,
                'error'    => null,
                'messages' => [
                    'success' => 'User Berhasil ditambahkan!'
                ]
            ];

            return $this->respond($response);
        } catch (\Exception $e) {
            $response = [
                'status'   => 500,
                'error'    => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ],
                'messages' => [
                    'error' => 'Gagal menambahkan user.'
                ]
            ];

            return $this->respond($response, 500);
        }
    }

    // single produk
    public function show($id = null)
    {
        $userModel = new UserModel();
        $data = $userModel->where('id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }

    // update
    public function update($id = null)
    {
        $userModel = new UserModel();

        // Ambil data dari permintaan PUT
        $data = $this->request->getRawInput();

        // Pastikan bahwa ID produk diambil dari parameter URL atau data permintaan
        $id = $id ?? $data['id'] ?? null;

        // Ambil data yang diperlukan
        $dataToUpdate = [
            'nama_produk' => $data['nama_produk'] ?? null,
            'harga'       => $data['harga'] ?? null,
        ];

        $result = $userModel->update($id, $dataToUpdate);

        if ($result) {
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data produk berhasil diubah.'
                ]
            ];
        } else {
            $response = [
                'status'   => 500,
                'error'    => 'Gagal mengubah data produk.',
                'messages' => null
            ];
        }

        return $this->respond($response);
    }

    // delete
    public function delete($id = null)
    {
        $userModel = new UserModel();
        $data = $userModel->where('id', $id)->delete($id);
        if ($data) {
            $userModel->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data produk berhasil dihapus.'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }
}
