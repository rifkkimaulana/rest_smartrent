<?php

namespace App\Controllers\Api\Inventaris;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\InventarisModel;

class Inventaris extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $InventarisModel = new InventarisModel();

        $dataInventaris = $InventarisModel->orderBy('id', 'DESC')->findAll();
        if ($dataInventaris) {
            $data = [
                'status' => 200,
                'data' => $dataInventaris
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Inventaris Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function create()
    {
        $InventarisModel = new InventarisModel();

        function generateUniqueString()
        {
            $uniqueString = substr(uniqid(), -5);
            return $uniqueString;
        }

        $data = [
            'nama_barang' =>  $this->request->getVar('nama_barang'),
            'kategori_id' => $this->request->getVar('kategori_id'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'harga_sewa' => $this->request->getVar('harga_sewa'),
            'stok' => $this->request->getVar('stok'),
            'gambar' => $this->request->getVar('gambar'),
            'durasi_sewa' => $this->request->getVar('durasi_sewa'),
            'status' => $this->request->getVar('status'),
            'informasi_tambahan' => $this->request->getVar('informasi_tambahan'),
        ];

        if ($InventarisModel->insert($data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Inventaris Berhasil ditambahkan!'
                ]
            ];
        } else {
            $data = [
                'status'   => 400,
                'data' => [
                    'messages' => 'Inventaris Gagal ditambahkan!'
                ]
            ];
        }

        return $this->respond($data);
    }

    public function update($id = null)
    {
        $InventarisModel = new InventarisModel();
        $data = [
            'nama_barang' =>  $this->request->getVar('nama_barang'),
            'kategori_id' => $this->request->getVar('kategori_id'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'harga_sewa' => $this->request->getVar('harga_sewa'),
            'stok' => $this->request->getVar('stok'),
            'gambar' => $this->request->getVar('gambar'),
            'durasi_sewa' => $this->request->getVar('durasi_sewa'),
            'status' => $this->request->getVar('status'),
            'informasi_tambahan' => $this->request->getVar('informasi_tambahan'),
        ];

        if ($InventarisModel->update($id, $data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Inventaris Berhasil diubah!'
                ]
            ];
        } else {
            $data = [
                'status'   => 500,
                'data' => [
                    'messages' => 'Inventaris Gagal diubah!'
                ]
            ];
        }
        return $this->respond($data);
    }


    public function show($id = null)
    {
        $InventarisModel = new InventarisModel();
        $data = $InventarisModel->where('id', $id)->first();
        if ($data) {

            $data = [
                'status' => 200,
                'data' => [$data]
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Inventaris Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function delete($id = null)
    {
        $InventarisModel = new InventarisModel();
        $data = $InventarisModel->where('id', $id)->first();

        if ($data) {
            if ($InventarisModel->delete($id)) {
                $data = [
                    'status'   => 204,
                    'success' => [
                        'messages' => 'Data Inventaris berhasil dihapus.'
                    ]
                ];
            } else {
                $data = [
                    'status'   => 500,
                    'error' => [
                        'messages' => 'Kesalahan sistem tidak dapat menghapus Inventaris terpilih.'
                    ]
                ];
            }
        } else {
            $data = [
                'status'   => 404,
                'error' => [
                    'messages' => 'Data Inventaris Tidak Tersedia.'
                ]
            ];
        }
        return $this->respond($data);
    }
}
