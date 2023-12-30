<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProdukModel;

class Produk extends ResourceController
{
    use ResponseTrait;

    // all produk
    public function index()
    {
        $model = new ProdukModel();
        $data = [
            'status' => TRUE,
            'data' => $model->orderBy('id', 'DESC')->findAll()
        ];
        return $this->respond($data);
    }

    // create
    public function create()
    {
        $model = new ProdukModel();
        $data = [
            'nama_produk' => $this->request->getVar('nama_produk'),
            'harga'  => $this->request->getVar('harga'),
        ];

        $model->insert($data);

        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data produk berhasil ditambahkan.'
            ]
        ];

        return $this->respondCreated($response);
    }

    // single produk
    public function show($id = null)
    {
        $model = new ProdukModel();
        $data = $model->where('id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }

    // update
    public function update($id = null)
    {
        $model = new ProdukModel();

        // Ambil data dari permintaan PUT
        $data = $this->request->getRawInput();

        // Pastikan bahwa ID produk diambil dari parameter URL atau data permintaan
        $id = $id ?? $data['id'] ?? null;

        // Ambil data yang diperlukan
        $dataToUpdate = [
            'nama_produk' => $data['nama_produk'] ?? null,
            'harga'       => $data['harga'] ?? null,
        ];

        $result = $model->update($id, $dataToUpdate);

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
        $model = new ProdukModel();
        $data = $model->where('id', $id)->delete($id);
        if ($data) {
            $model->delete($id);
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
