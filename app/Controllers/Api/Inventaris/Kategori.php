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
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
        $id = $this->request->getVar('id');
        $KategoriModel = new KategoriModel();

        if (!empty($_FILES['gambar']['tmp_name'])) {
            $errors = array();
            $allowed_ext = array('jpg', 'jpeg', 'png',);
            $file_size = $_FILES['gambar']['size'];
            $file_tmp = $_FILES['gambar']['tmp_name'];
            //$type = pathinfo($file_tmp, PATHINFO_EXTENSION);
            $type = 'jpeg';
            $data = file_get_contents($file_tmp);
            $tmp = explode('.', $_FILES['gambar']['name']);
            $file_ext = end($tmp);

            if (in_array($file_ext, $allowed_ext) === false) {
                $errors[] = 'Ekstensi file tidak di izinkan';
                echo json_encode(['status' => false, 'message' => 'Ekstensi file tidak di izinkan']);
                die();
            }

            if ($file_size > 2097152) {
                $errors[] = 'Ukuran file maksimal 2 MB';
                echo json_encode(['status' => false, 'message' => 'Ukuran file maksimal 2 MB']);
                die();
            }

            if (empty($errors)) {
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                $data = [
                    'nama_kategori' =>  $this->request->getVar('nama_kategori'),
                    'gambar_kategori' => $base64
                ];
            }
        } else {


            $data = [
                'nama_kategori' =>  $this->request->getVar('nama_kategori'),
            ];
        }

        if (empty($id)) {
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
        } else {
            if ($KategoriModel->update($id, $data)) {
                $data = [
                    'status'   => 201,
                    'data' => [
                        'messages' => 'Kategori Berhasil diubah!'
                    ]
                ];
            } else {
                $data = [
                    'status'   => 400,
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
