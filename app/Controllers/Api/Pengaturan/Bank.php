<?php

namespace App\Controllers\Api\Pengaturan;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\BankModel;

class Bank extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $BankModel = new BankModel();

        $dataBank = $BankModel->orderBy('id', 'DESC')->findAll();
        if ($dataBank) {
            $data = [
                'status' => 200,
                'data' => $dataBank
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Bank Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function create()
    {
        $BankModel = new BankModel();

        $data = [
            'user_id' => $this->request->getVar('user_id'),
            'daftar_bank_id' => $this->request->getVar('daftar_bank_id'),
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'nomor_rekening' => $this->request->getVar('nomor_rekening'),
        ];

        if ($BankModel->insert($data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Bank Berhasil ditambahkan!'
                ]
            ];
        } else {
            $data = [
                'status'   => 400,
                'data' => [
                    'messages' => 'Bank Gagal ditambahkan!'
                ]
            ];
        }

        return $this->respond($data);
    }

    public function update($id = null)
    {
        $BankModel = new BankModel();

        $data = [
            'Bank_id' => $this->request->getVar('Bank_id'),
            'daftar_bank_id' => $this->request->getVar('daftar_bank_id'),
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'nomor_rekening' => $this->request->getVar('nomor_rekening'),
        ];

        if ($BankModel->update($id, $data)) {
            $data = [
                'status'   => 201,
                'data' => [
                    'messages' => 'Bank Berhasil diubah!'
                ]
            ];
        } else {
            $data = [
                'status'   => 500,
                'data' => [
                    'messages' => 'Bank Gagal diubah!'
                ]
            ];
        }
        return $this->respond($data);
    }


    public function show($id = null)
    {
        $BankModel = new BankModel();
        $data = $BankModel->where('id', $id)->first();
        if ($data) {

            $data = [
                'status' => 200,
                'data' => [$data]
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Bank Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function delete($id = null)
    {
        $BankModel = new BankModel();
        $data = $BankModel->where('id', $id)->first();

        if ($data) {
            if ($BankModel->delete($id)) {
                $data = [
                    'status'   => 204,
                    'success' => [
                        'messages' => 'Data Bank berhasil dihapus.'
                    ]
                ];
            } else {
                $data = [
                    'status'   => 500,
                    'error' => [
                        'messages' => 'Kesalahan sistem tidak dapat menghapus Bank terpilih.'
                    ]
                ];
            }
        } else {
            $data = [
                'status'   => 404,
                'error' => [
                    'messages' => 'Data Bank Tidak Tersedia.'
                ]
            ];
        }
        return $this->respond($data);
    }
}
