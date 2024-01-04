<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModel;

class Users extends ResourceController
{
    use ResponseTrait;

    public function login()
    {

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');


        $UsersModel = new UsersModel();
        $user = $UsersModel->where('username', $username)->first();

        if (password_verify($password, $user['password'])) {
            $data = [
                'status' => 200,
                'data' => $user
            ];
        } else {
            $data = [
                'status' => 401,
                'data' => [
                    'messages' => 'Password or Username yang anda masukan salah.'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function index()
    {
        $UsersModel = new UsersModel();

        $dataUser = $UsersModel->orderBy('id', 'DESC')->findAll();
        if ($dataUser) {
            $data = [
                'status' => 200,
                'data' => $dataUser
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Pengguna Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function create()
    {
        $id = $this->request->getPost('id');
        $password = $this->request->getPost('password');
        $re_password = $this->request->getPost('re_password');

        if ($password === $re_password) {
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
                        'nama_lengkap' => $this->request->getVar('nama_lengkap'),
                        'username' => $this->request->getVar('username'),
                        'password' => password_hash($password, PASSWORD_DEFAULT),
                        'alamat_email' => $this->request->getVar('email'),
                        'telpon' => $this->request->getVar('telpon'),
                        'user_level' => $this->request->getVar('user_level'),
                        'gambar' => $base64
                    ];
                }
            } else {
                $data = [
                    'nama_lengkap' => $this->request->getVar('nama_lengkap'),
                    'username' => $this->request->getVar('username'),
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'alamat_email' => $this->request->getVar('email'),
                    'telpon' => $this->request->getVar('telpon'),
                    'user_level' => $this->request->getVar('user_level'),
                ];
            }

            $UsersModel = new UsersModel();
            if (!empty($id)) {
                if ($UsersModel->update($id, $data)) {
                    $data = [
                        'status'   => 201,
                        'data' => [
                            'messages' => 'Pengguna Berhasil diubah!'
                        ]
                    ];
                } else {
                    $data = [
                        'status'   => 500,
                        'data' => [
                            'messages' => 'User Gagal diubah!'
                        ]
                    ];
                }
            } else {
                if ($UsersModel->insertData($data)) {
                    $data = [
                        'status'   => 201,
                        'data' => [
                            'messages' => 'Pengguna Berhasil ditambahkan!'
                        ]
                    ];
                } else {
                    $data = [
                        'status'   => 400,
                        'data' => [
                            'messages' => 'User Gagal ditambahkan!'
                        ]
                    ];
                }
            }
        } else {
            $data = [
                'status'   => 400,
                'data' => [
                    'messages' => 'Kolom password berbeda!'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function show($id = null)
    {
        $UsersModel = new UsersModel();
        $data = $UsersModel->where('id', $id)->first();
        if ($data) {

            $data = [
                'status' => 200,
                'data' => [$data]
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Pengguna Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function delete($id = null)
    {

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: DELETE");
        header('Content-Type: application/json');

        $UsersModel = new UsersModel();
        $data = $UsersModel->where('id', $id)->first();

        if ($data) {
            if ($UsersModel->deleteId($id)) {
                $data = [
                    'status'   => 204,
                    'success' => [
                        'messages' => 'Data user berhasil dihapus.'
                    ]
                ];
            } else {
                $data = [
                    'status'   => 500,
                    'error' => [
                        'messages' => 'Kesalahan sistem tidak dapat menghapus user terpilih.'
                    ]
                ];
            }
        } else {
            $data = [
                'status'   => 404,
                'error' => [
                    'messages' => 'Data Pengguna Tidak Tersedia.'
                ]
            ];
        }
        return $this->respond($data);
    }
}
