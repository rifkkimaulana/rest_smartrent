<?php

namespace App\Controllers\Api\Perjalanan;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PemesananPerjalananModel;

class Pemesanan_perjalanan extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $PemesananPerjalananModel = new PemesananPerjalananModel();

        $dataPerjalanan = $PemesananPerjalananModel->orderBy('id', 'DESC')->findAll();
        if ($dataPerjalanan) {
            $data = [
                'status' => 200,
                'data' => $dataPerjalanan
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Perjalanan Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function create()
    {
        $PemesananPerjalananModel = new PemesananPerjalananModel();

        function generateUniqueString()
        {
            $uniqueString = substr(uniqid(), -5);
            return $uniqueString;
        }
        $data = [
            'kategori_id' =>  $this->request->getVar('nama_Perjalanan'),
            'nama_Perjalanan' =>  $this->request->getVar('nama_Perjalanan'),
            'deskripsi' =>  $this->request->getVar('nama_Perjalanan'),
            'harga_Perjalanan' =>  $this->request->getVar('nama_Perjalanan'),
            'kuota_peserta' =>  $this->request->getVar('nama_Perjalanan'),
            'gambar_Perjalanan' =>  $this->request->getVar('nama_Perjalanan'),
        ];

        if ($PemesananPerjalananModel->insert($data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Perjalanan Berhasil ditambahkan!'
                ]
            ];
        } else {
            $data = [
                'status'   => 400,
                'data' => [
                    'messages' => 'Perjalanan Gagal ditambahkan!'
                ]
            ];
        }

        return $this->respond($data);
    }

    public function update($id = null)
    {
        $PemesananPerjalananModel = new PemesananPerjalananModel();

        $data = [
            'kategori_id' =>  $this->request->getVar('nama_Perjalanan'),
            'nama_Perjalanan' =>  $this->request->getVar('nama_Perjalanan'),
            'deskripsi' =>  $this->request->getVar('nama_Perjalanan'),
            'harga_Perjalanan' =>  $this->request->getVar('nama_Perjalanan'),
            'kuota_peserta' =>  $this->request->getVar('nama_Perjalanan'),
            'gambar_Perjalanan' =>  $this->request->getVar('nama_Perjalanan'),
        ];

        if ($PemesananPerjalananModel->update($id, $data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Perjalanan Berhasil diubah!'
                ]
            ];
        } else {
            $data = [
                'status'   => 500,
                'data' => [
                    'messages' => 'Perjalanan Gagal diubah!'
                ]
            ];
        }
        return $this->respond($data);
    }


    public function show($id = null)
    {
        $PemesananPerjalananModel = new PemesananPerjalananModel();
        $data = $PemesananPerjalananModel->where('id', $id)->first();
        if ($data) {

            $data = [
                'status' => 200,
                'data' => [$data]
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Perjalanan Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function delete($id = null)
    {
        $PemesananPerjalananModel = new PemesananPerjalananModel();
        $data = $PemesananPerjalananModel->where('id', $id)->first();

        if ($data) {
            if ($PemesananPerjalananModel->delete($id)) {
                $data = [
                    'status'   => 204,
                    'success' => [
                        'messages' => 'Data Perjalanan berhasil dihapus.'
                    ]
                ];
            } else {
                $data = [
                    'status'   => 500,
                    'error' => [
                        'messages' => 'Kesalahan sistem tidak dapat menghapus Perjalanan terpilih.'
                    ]
                ];
            }
        } else {
            $data = [
                'status'   => 404,
                'error' => [
                    'messages' => 'Data Perjalanan Tidak Tersedia.'
                ]
            ];
        }
        return $this->respond($data);
    }
}
