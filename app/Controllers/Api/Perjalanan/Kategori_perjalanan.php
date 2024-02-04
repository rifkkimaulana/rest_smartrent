<?php

namespace App\Controllers\Api\Perjalanan;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\KategoriPerjalananModel;

class Kategori_perjalanan extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $KategoriPerjalananModel = new KategoriPerjalananModel();

        $dataKategori = $KategoriPerjalananModel->orderBy('id', 'DESC')->findAll();
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
        $KategoriPerjalananModel = new KategoriPerjalananModel();
        $id = $this->request->getVar('id');


        $data = [
            'nama_kategori' =>  $this->request->getVar('nama_kategori'),

        ];

        if (empty($id)) {
            if ($KategoriPerjalananModel->insert($data)) {
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
        } else {
            if ($KategoriPerjalananModel->update($id, $data)) {
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
        }
        return $this->respond($data);
    }

    public function show($id = null)
    {
        $KategoriPerjalananModel = new KategoriPerjalananModel();
        $data = $KategoriPerjalananModel->where('id', $id)->first();
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
        $KategoriPerjalananModel = new KategoriPerjalananModel();
        $data = $KategoriPerjalananModel->where('id', $id)->first();

        if ($data) {
            if ($KategoriPerjalananModel->delete($id)) {
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
