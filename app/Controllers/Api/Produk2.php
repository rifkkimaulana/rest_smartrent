<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\InventarisModel;

class Produk2 extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $inventarisModel = new InventarisModel();

        $dataUser = $inventarisModel->orderBy('id', 'DESC')->findAll();
        if ($dataUser) {
            $data = [
                'status' => 200,
                'data' => $dataUser
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Produk Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function create()
    {
        $UsersModel = new InventarisModel();

        $data = [
            'nama_barang' => $this->request->getVar('nama_barang'),
            'kategori_id' => $this->request->getVar('kategori_id'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'harga_sewa' => $this->request->getVar('harga_sewa'),
            'stok' => $this->request->getVar('stok'),
            'gambar' => $this->request->getVar('gambar'),
            'informasi_tambahan' => $this->request->getVar('informasi_tambahan'),
            'durasi_sewa' => $this->request->getVar('durasi_sewa'),
        ];

        if ($UsersModel->insert($data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Produk Berhasil ditambahkan!'
                ]
            ];
        } else {
            $data = [
                'status'   => 400,
                'data' => [
                    'messages' => 'User Gagal ditambahkan!'
                ]
            ];
        }

        return $this->respond($data);
    }

    public function update($id = null)
    {
        $inventarisModel = new InventarisModel();

        $data = [
            'nama_barang' => $this->request->getVar('nama_barang'),
            'kategori_id' => $this->request->getVar('kategori_id'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'harga_sewa' => $this->request->getVar('harga_sewa'),
            'stok' => $this->request->getVar('stok'),
            'gambar' => $this->request->getVar('gambar'),
            'informasi_tambahan' => $this->request->getVar('informasi_tambahan'),
            'durasi_sewa' => $this->request->getVar('durasi_sewa'),
        ];

        if ($id) {
            if ($inventarisModel->update($id, $data)) {
                $response = [
                    'status'   => 200,
                    'data' => [
                        'messages' => 'Data:' . $this->request->getVar('nama_lengkap') . 'Berhasil diubah!.',
                    ]
                ];
            } else {

                $response = [
                    'status'   => 500,
                    'data' => [
                        'messages' => 'Kesalahan saat menghapus Produk.'
                    ]
                ];
            }
        } else {
            $response = [
                'status'   => 404,
                'data' => [
                    'messages' => 'Data Produk Tidak Tersedia untuk diubah.'
                ]
            ];
        }
        return $this->respond($response);
    }

    public function show($id = null)
    {
        $inventarisModel = new InventarisModel();
        $data = $inventarisModel->where('id', $id)->first();
        if ($data) {

            $data = [
                'status' => 200,
                'data' => [$data]
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Produk Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function delete($id = null)
    {
        $inventarisModel = new InventarisModel();
        $data = $inventarisModel->where('id', $id)->first();

        if ($data) {
            if ($inventarisModel->delete($id)) {
                $data = [
                    'status'   => 204,
                    'success' => [
                        'messages' => 'Data user berhasil dihapus.'
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
                    'messages' => 'Data Produk Tidak Tersedia.'
                ]
            ];
        }
        return $this->respond($data);
    }
}
