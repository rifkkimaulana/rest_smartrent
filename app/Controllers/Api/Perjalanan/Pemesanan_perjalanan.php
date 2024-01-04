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
        $id = $this->request->getVar('id');
        $PemesananPerjalananModel = new PemesananPerjalananModel();

        $data = [
            'no_transaksi' =>  substr(uniqid(), -5),
            'user_id' =>  $this->request->getVar('user_id'),
            'paket_id' =>  $this->request->getVar('paket_id'),
            'jumlah_peserta' =>  $this->request->getVar('jumlah_peserta'),
            'total_pembayaran' =>  $this->request->getVar('total_pembayaran'),
            'tanggal_pemesanan' =>  $this->request->getVar('tanggal_pemesanan'),
            'status_pembayaran' =>  $this->request->getVar('status_pembayaran'),
        ];

        if (empty($id)) {
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
        } else {
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
