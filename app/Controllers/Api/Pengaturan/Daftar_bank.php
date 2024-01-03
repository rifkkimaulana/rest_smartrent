<?php

namespace App\Controllers\Api\Pengaturan;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\DaftarBankModel;

class Daftar_bank extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $DaftarBankModel = new DaftarBankModel();

        $dataBank = $DaftarBankModel->orderBy('id', 'DESC')->findAll();
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
        $DaftarBankModel = new DaftarBankModel();

        $data = [
            'nama_bank' => $this->request->getVar('user_id'),
            'logo_bank' => $this->request->getVar('daftar_bank_id'),
        ];

        if ($DaftarBankModel->insert($data)) {
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
        $DaftarBankModel = new DaftarBankModel();

        $data = [
            'nama_bank' => $this->request->getVar('user_id'),
            'logo_bank' => $this->request->getVar('daftar_bank_id'),
        ];

        if ($DaftarBankModel->update($id, $data)) {
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
        $DaftarBankModel = new DaftarBankModel();
        $data = $DaftarBankModel->where('id', $id)->first();
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
        $DaftarBankModel = new DaftarBankModel();
        $data = $DaftarBankModel->where('id', $id)->first();

        if ($data) {
            if ($DaftarBankModel->delete($id)) {
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
