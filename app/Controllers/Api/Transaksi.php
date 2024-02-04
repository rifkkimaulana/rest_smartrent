<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TransaksiModel;

class Transaksi extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $TransaksiModel = new TransaksiModel();

        $dataTransaksi = $TransaksiModel->orderBy('id', 'DESC')->findAll();
        if ($dataTransaksi) {
            $data = [
                'status' => 200,
                'data' => $dataTransaksi
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Transaksi Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function create()
    {
        $TransaksiModel = new TransaksiModel();

        function generateUniqueString()
        {
            $uniqueString = substr(uniqid(), -5);
            return $uniqueString;
        }

        $uniqueCode = generateUniqueString();

        $data = [
            'no_transaksi' => $uniqueCode,
            'user_id' => $this->request->getVar('user_id'),
            'tanggal_penyewaan' => $this->request->getVar('tanggal_penyewaan'),
            'tanggal_pengembalian' => $this->request->getVar('tanggal_pengembalian'),
            'total_harga' => $this->request->getVar('total_harga'),
            'status_transaksi' => $this->request->getVar('status_transaksi'),
        ];

        if ($TransaksiModel->insert($data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Transaksi Berhasil ditambahkan!'
                ]
            ];
        } else {
            $data = [
                'status'   => 400,
                'data' => [
                    'messages' => 'Transaksi Gagal ditambahkan!'
                ]
            ];
        }

        return $this->respond($data);
    }

    public function update($id = null)
    {
        $TransaksiModel = new TransaksiModel();

        $data = [
            'user_id' => $this->request->getVar('user_id'),
            'tanggal_penyewaan' => $this->request->getVar('tanggal_penyewaan'),
            'tanggal_pengembalian' => $this->request->getVar('tanggal_pengembalian'),
            'total_harga' => $this->request->getVar('total_harga'),
            'status_transaksi' => $this->request->getVar('status_transaksi'),
        ];

        if ($TransaksiModel->update($id, $data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Transaksi Berhasil diubah!'
                ]
            ];
        } else {
            $data = [
                'status'   => 500,
                'data' => [
                    'messages' => 'Transaksi Gagal diubah!'
                ]
            ];
        }
        return $this->respond($data);
    }


    public function show($id = null)
    {
        $TransaksiModel = new TransaksiModel();
        $data = $TransaksiModel->where('id', $id)->first();
        if ($data) {

            $data = [
                'status' => 200,
                'data' => [$data]
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Transaksi Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function delete($id = null)
    {
        $TransaksiModel = new TransaksiModel();
        $data = $TransaksiModel->where('id', $id)->first();

        if ($data) {
            if ($TransaksiModel->delete($id)) {
                $data = [
                    'status'   => 204,
                    'success' => [
                        'messages' => 'Data Transaksi berhasil dihapus.'
                    ]
                ];
            } else {
                $data = [
                    'status'   => 500,
                    'error' => [
                        'messages' => 'Kesalahan sistem tidak dapat menghapus Transaksi terpilih.'
                    ]
                ];
            }
        } else {
            $data = [
                'status'   => 404,
                'error' => [
                    'messages' => 'Data Transaksi Tidak Tersedia.'
                ]
            ];
        }
        return $this->respond($data);
    }
}
