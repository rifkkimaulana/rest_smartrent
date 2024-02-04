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
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

        $id = $this->request->getVar('id');
        $PaketPerjalananModel = new PaketPerjalananModel();

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
                    'kategori_id' =>  $this->request->getVar('kategori_id'),
                    'nama_paket' =>  $this->request->getVar('nama_paket'),
                    'deskripsi' =>  $this->request->getVar('deskripsi'),
                    'harga_paket' =>  $this->request->getVar('harga_paket'),
                    'kuota_peserta' =>  $this->request->getVar('kuota_peserta'),
                    'gambar_paket' =>  $base64
                ];
            }
        } else {
            $data = [
                'kategori_id' =>  $this->request->getVar('kategori_id'),
                'nama_paket' =>  $this->request->getVar('nama_paket'),
                'deskripsi' =>  $this->request->getVar('deskripsi'),
                'harga_paket' =>  $this->request->getVar('harga_paket'),
                'kuota_peserta' =>  $this->request->getVar('kuota_peserta'),
            ];
        }


        if (empty($id)) {
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
        } else {
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
        }
        return $this->respond($data);
    }

    public function show($id = null)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
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
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

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
