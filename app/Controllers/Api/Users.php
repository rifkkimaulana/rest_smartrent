<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModel;

class Users extends ResourceController
{
    use ResponseTrait;

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
        $UsersModel = new UsersModel();

        $password = $this->request->getPost('password');
        $re_password = $this->request->getPost('re_password');

        if ($password === $re_password) {

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
        $UsersModel = new UsersModel();
        $data = $UsersModel->where('id', $id)->first();

        if ($data) {
            if ($UsersModel->delete($id)) {
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
