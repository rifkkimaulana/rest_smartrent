<?php

namespace App\Controllers\Api\Inventaris;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\KategoriModel;

class Kategori extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $KategoriModel = new KategoriModel();

        $dataKategori = $KategoriModel->orderBy('id', 'DESC')->findAll();
        if ($dataKategori) {
            $data = [
                'status' => 200,
                'data' => $dataKategori
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Kategori Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function create()
    {
        $KategoriModel = new KategoriModel();

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

        if ($KategoriModel->insert($data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Kategori Berhasil ditambahkan!'
                ]
            ];
        } else {
            $data = [
                'status'   => 400,
                'data' => [
                    'messages' => 'Kategori Gagal ditambahkan!'
                ]
            ];
        }

        return $this->respond($data);
    }

    public function update($id = null)
    {
        $KategoriModel = new KategoriModel();
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

        if ($KategoriModel->update($id, $data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Kategori Berhasil diubah!'
                ]
            ];
        } else {
            $data = [
                'status'   => 500,
                'data' => [
                    'messages' => 'Kategori Gagal diubah!'
                ]
            ];
        }
        return $this->respond($data);
    }


    public function show($id = null)
    {
        $KategoriModel = new KategoriModel();
        $data = $KategoriModel->where('id', $id)->first();
        if ($data) {

            $data = [
                'status' => 200,
                'data' => [$data]
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Kategori Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function delete($id = null)
    {
        $KategoriModel = new KategoriModel();
        $data = $KategoriModel->where('id', $id)->first();

        if ($data) {
            if ($KategoriModel->delete($id)) {
                $data = [
                    'status'   => 204,
                    'success' => [
                        'messages' => 'Data Kategori berhasil dihapus.'
                    ]
                ];
            } else {
                $data = [
                    'status'   => 500,
                    'error' => [
                        'messages' => 'Kesalahan sistem tidak dapat menghapus Kategori terpilih.'
                    ]
                ];
            }
        } else {
            $data = [
                'status'   => 404,
                'error' => [
                    'messages' => 'Data Kategori Tidak Tersedia.'
                ]
            ];
        }
        return $this->respond($data);
    }
}
