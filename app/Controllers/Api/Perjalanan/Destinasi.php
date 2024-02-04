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
        $id = $this->request->getVar('id');
        $DestinasiModel = new DestinasiModel();
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
                    'nama_destinasi' =>  $this->request->getVar('nama_destinasi'),
                    'deskripsi' => $this->request->getVar('deskripsi'),
                    'lokasi' => $this->request->getVar('lokasi'),
                    'gambar_destinasi' => $base64,
                ];
            }
        } else {
            $data = [
                'nama_destinasi' =>  $this->request->getVar('nama_destinasi'),
                'deskripsi' => $this->request->getVar('deskripsi'),
                'lokasi' => $this->request->getVar('lokasi'),
            ];
        }

        if (empty($id)) {
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
        } else {
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
