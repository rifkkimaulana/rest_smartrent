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
        $id = $this->request->getVar('id');
        $DaftarBankModel = new DaftarBankModel();

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
                    'nama_bank' => $this->request->getVar('nama_bank'),
                    'logo_bank' => $base64,
                ];
            }
        } else {
            $data = [
                'nama_bank' => $this->request->getVar('nama_bank'),
            ];
        }

        if (empty($id)) {
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
        } else {
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
