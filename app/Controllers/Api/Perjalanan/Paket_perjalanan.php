<?php

namespace App\Controllers\Api\Perjalanan;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PaketPerjalananModel;

class Paket_perjalanan extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $PaketPerjalananModel = new PaketPerjalananModel();

        $dataPaket = $PaketPerjalananModel->orderBy('id', 'DESC')->findAll();
        if ($dataPaket) {
            $data = [
                'status' => 200,
                'data' => $dataPaket
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Paket Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function create()
    {
        $PaketPerjalananModel = new PaketPerjalananModel();

        function generateUniqueString()
        {
            $uniqueString = substr(uniqid(), -5);
            return $uniqueString;
        }
        $data = [
            'kategori_id' =>  $this->request->getVar('nama_Paket'),
            'nama_paket' =>  $this->request->getVar('nama_Paket'),
            'deskripsi' =>  $this->request->getVar('nama_Paket'),
            'harga_paket' =>  $this->request->getVar('nama_Paket'),
            'kuota_peserta' =>  $this->request->getVar('nama_Paket'),
            'gambar_paket' =>  $this->request->getVar('nama_Paket'),
        ];

        if ($PaketPerjalananModel->insert($data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Paket Berhasil ditambahkan!'
                ]
            ];
        } else {
            $data = [
                'status'   => 400,
                'data' => [
                    'messages' => 'Paket Gagal ditambahkan!'
                ]
            ];
        }

        return $this->respond($data);
    }

    public function update($id = null)
    {
        $PaketPerjalananModel = new PaketPerjalananModel();

        $data = [
            'kategori_id' =>  $this->request->getVar('nama_Paket'),
            'nama_paket' =>  $this->request->getVar('nama_Paket'),
            'deskripsi' =>  $this->request->getVar('nama_Paket'),
            'harga_paket' =>  $this->request->getVar('nama_Paket'),
            'kuota_peserta' =>  $this->request->getVar('nama_Paket'),
            'gambar_paket' =>  $this->request->getVar('nama_Paket'),
        ];

        if ($PaketPerjalananModel->update($id, $data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Paket Berhasil diubah!'
                ]
            ];
        } else {
            $data = [
                'status'   => 500,
                'data' => [
                    'messages' => 'Paket Gagal diubah!'
                ]
            ];
        }
        return $this->respond($data);
    }


    public function show($id = null)
    {
        $PaketPerjalananModel = new PaketPerjalananModel();
        $data = $PaketPerjalananModel->where('id', $id)->first();
        if ($data) {

            $data = [
                'status' => 200,
                'data' => [$data]
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Paket Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function delete($id = null)
    {
        $PaketPerjalananModel = new PaketPerjalananModel();
        $data = $PaketPerjalananModel->where('id', $id)->first();

        if ($data) {
            if ($PaketPerjalananModel->delete($id)) {
                $data = [
                    'status'   => 204,
                    'success' => [
                        'messages' => 'Data Paket berhasil dihapus.'
                    ]
                ];
            } else {
                $data = [
                    'status'   => 500,
                    'error' => [
                        'messages' => 'Kesalahan sistem tidak dapat menghapus Paket terpilih.'
                    ]
                ];
            }
        } else {
            $data = [
                'status'   => 404,
                'error' => [
                    'messages' => 'Data Paket Tidak Tersedia.'
                ]
            ];
        }
        return $this->respond($data);
    }
}
