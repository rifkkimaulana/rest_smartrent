<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModel;

class Users extends ResourceController
{
    use ResponseTrait;

<<<<<<< HEAD
=======
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

>>>>>>> d0c76b3f604f3baf4faad642f3f4be6ccf8ef199
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
<<<<<<< HEAD
        $UsersModel = new UsersModel();

=======
        $id = $this->request->getPost('id');
>>>>>>> d0c76b3f604f3baf4faad642f3f4be6ccf8ef199
        $password = $this->request->getPost('password');
        $re_password = $this->request->getPost('re_password');

        if ($password === $re_password) {
<<<<<<< HEAD

            /*
            $file = $this->request->getFile('gambar');
            if ($file->isValid() && !$file->hasMoved()) {

                $newName = $file->getRandomName();
                $file->move('image/gambar/', $newName);
            }
            */

            $data = [
                'nama_lengkap' => $this->request->getVar('nama_lengkap'),
                'username' => $this->request->getVar('username'),
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'alamat_email' => $this->request->getVar('email'),
                'telpon' => $this->request->getVar('telpon'),
                'user_level' => $this->request->getVar('user_level'),
                //'gambar' => $newName,
            ];

            if ($UsersModel->insert($data)) {
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
=======
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
>>>>>>> d0c76b3f604f3baf4faad642f3f4be6ccf8ef199
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

<<<<<<< HEAD
    public function update($id = null)
    {
        $UsersModel = new UsersModel();
        $password =  $this->request->getVar('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $data = [
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'username' => $this->request->getVar('username'),
            'alamat_email' => $this->request->getVar('email'),
            'telpon' => $this->request->getVar('telpon'),
            'user_level' => $this->request->getVar('user_level'),
            'gambar' => $this->request->getVar('gambar'),
        ];

        if ($id) {
            if ($UsersModel->update($id, $data)) {
                $response = [
                    'status'   => 200,
                    'data' => [
                        'messages' => 'Data:' . $this->request->getVar('nama_lengkap') . 'Berhasil diubah!.',
                    ]
                ];
            } else {

                $response = [
                    'status'   => 500,
                    'data' => [
                        'messages' => 'Kesalahan saat menghapus pengguna.'
                    ]
                ];
            }
        } else {
            $response = [
                'status'   => 404,
                'data' => [
                    'messages' => 'Data Pengguna Tidak Tersedia untuk diubah.'
                ]
            ];
        }
        return $this->respond($response);
    }

=======
>>>>>>> d0c76b3f604f3baf4faad642f3f4be6ccf8ef199
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
<<<<<<< HEAD
=======

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: DELETE");
        header('Content-Type: application/json');

>>>>>>> d0c76b3f604f3baf4faad642f3f4be6ccf8ef199
        $UsersModel = new UsersModel();
        $data = $UsersModel->where('id', $id)->first();

        if ($data) {
<<<<<<< HEAD
            if ($UsersModel->delete($id)) {
=======
            if ($UsersModel->deleteId($id)) {
>>>>>>> d0c76b3f604f3baf4faad642f3f4be6ccf8ef199
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
