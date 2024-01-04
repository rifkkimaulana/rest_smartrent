<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TransaksiDuitkuModel;

class Pembayaran extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $TransaksiDuitkuModel = new TransaksiDuitkuModel();

        $dataPembayaran = $TransaksiDuitkuModel->orderBy('id', 'DESC')->findAll();
        if ($dataPembayaran) {
            $data = [
                'status' => 200,
                'data' => $dataPembayaran
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Pembayaran Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function create()
    {
        $TransaksiDuitkuModel = new TransaksiDuitkuModel();

        function generateUniqueString()
        {
            $uniqueString = substr(uniqid(), -5);
            return $uniqueString;
        }

        $uniqueCode = generateUniqueString();

        $data = [
            'no_Pembayaran' => $uniqueCode,
            'user_id' => $this->request->getVar('user_id'),
            'tanggal_penyewaan' => $this->request->getVar('tanggal_penyewaan'),
            'tanggal_pengembalian' => $this->request->getVar('tanggal_pengembalian'),
            'total_harga' => $this->request->getVar('total_harga'),
            'status_Pembayaran' => $this->request->getVar('status_Pembayaran'),
        ];

        if ($TransaksiDuitkuModel->insert($data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Pembayaran Berhasil ditambahkan!'
                ]
            ];
        } else {
            $data = [
                'status'   => 400,
                'data' => [
                    'messages' => 'Pembayaran Gagal ditambahkan!'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function show($id = null)
    {
        $TransaksiDuitkuModel = new TransaksiDuitkuModel();
        $data = $TransaksiDuitkuModel->where('id', $id)->first();
        if ($data) {

            $data = [
                'status' => 200,
                'data' => [$data]
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Pembayaran Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function delete($id = null)
    {
        $TransaksiDuitkuModel = new TransaksiDuitkuModel();
        $data = $TransaksiDuitkuModel->where('id', $id)->first();

        if ($data) {
            if ($TransaksiDuitkuModel->delete($id)) {
                $data = [
                    'status'   => 204,
                    'success' => [
                        'messages' => 'Data Pembayaran berhasil dihapus.'
                    ]
                ];
            } else {
                $data = [
                    'status'   => 500,
                    'error' => [
                        'messages' => 'Kesalahan sistem tidak dapat menghapus Pembayaran terpilih.'
                    ]
                ];
            }
        } else {
            $data = [
                'status'   => 404,
                'error' => [
                    'messages' => 'Data Pembayaran Tidak Tersedia.'
                ]
            ];
        }
        return $this->respond($data);
    }
}
