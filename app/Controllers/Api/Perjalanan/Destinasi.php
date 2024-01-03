<?php

namespace App\Controllers\Api\Perjalanan;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\DestinasiModel;

class Destinasi extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $DestinasiModel = new DestinasiModel();

        $dataDestinasi = $DestinasiModel->orderBy('id', 'DESC')->findAll();
        if ($dataDestinasi) {
            $data = [
                'status' => 200,
                'data' => $dataDestinasi
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Destinasi Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function create()
    {
        $DestinasiModel = new DestinasiModel();

        function generateUniqueString()
        {
            $uniqueString = substr(uniqid(), -5);
            return $uniqueString;
        }

        $data = [
            'nama_destinasi' =>  $this->request->getVar('nama_destinasi'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'lokasi' => $this->request->getVar('lokasi'),
            'gambar_destinasi' => $this->request->getVar('gambar_destinasi'),

        ];

        if ($DestinasiModel->insert($data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Destinasi Berhasil ditambahkan!'
                ]
            ];
        } else {
            $data = [
                'status'   => 400,
                'data' => [
                    'messages' => 'Destinasi Gagal ditambahkan!'
                ]
            ];
        }

        return $this->respond($data);
    }

    public function update($id = null)
    {
        $DestinasiModel = new DestinasiModel();

        $data = [
            'nama_destinasi' =>  $this->request->getVar('nama_destinasi'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'lokasi' => $this->request->getVar('lokasi'),
            'gambar_destinasi' => $this->request->getVar('gambar_destinasi'),

        ];
        if ($DestinasiModel->update($id, $data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Destinasi Berhasil diubah!'
                ]
            ];
        } else {
            $data = [
                'status'   => 500,
                'data' => [
                    'messages' => 'Destinasi Gagal diubah!'
                ]
            ];
        }
        return $this->respond($data);
    }


    public function show($id = null)
    {
        $DestinasiModel = new DestinasiModel();
        $data = $DestinasiModel->where('id', $id)->first();
        if ($data) {

            $data = [
                'status' => 200,
                'data' => [$data]
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Destinasi Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function delete($id = null)
    {
        $DestinasiModel = new DestinasiModel();
        $data = $DestinasiModel->where('id', $id)->first();

        if ($data) {
            if ($DestinasiModel->delete($id)) {
                $data = [
                    'status'   => 204,
                    'success' => [
                        'messages' => 'Data Destinasi berhasil dihapus.'
                    ]
                ];
            } else {
                $data = [
                    'status'   => 500,
                    'error' => [
                        'messages' => 'Kesalahan sistem tidak dapat menghapus Destinasi terpilih.'
                    ]
                ];
            }
        } else {
            $data = [
                'status'   => 404,
                'error' => [
                    'messages' => 'Data Destinasi Tidak Tersedia.'
                ]
            ];
        }
        return $this->respond($data);
    }
}
