<?php

namespace App\Controllers\Api;

use App\Models\KategoriModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\InventarisModel;
use App\Models\ProdukModel;

class Produk extends ResourceController
{
    use ResponseTrait;

    public function limit_produk()
    {

        $limit = $this->request->getPost('limit');
        $start = $this->request->getPost('start');
        $search = $this->request->getPost('search');
        $kategori = $this->request->getPost('kategori');

        if (!empty($kategori)) {
            $kategoriModel = new KategoriModel();
            $kategoriNama = $kategoriModel->where('id', $kategori)->first();
            $namaKategori = $kategoriNama['nama'];
        } else {
            $namaKategori = '';
        }

        $data = new ProdukModel();
        $produk = $data->fetch_data($limit, $start, $search, $namaKategori);

        $rowCount = $data->countAllResults();

        if ($rowCount == 0 && $start == 0) {
            $result = 0;
        } else {
            $result = 1;
        }

        if ($rowCount > 0) {
            return $this->respond(
                [
                    'status' => TRUE,
                    'data' => $produk->getResult(),
                    'result' => $result,
                ],
                200
            );
        } else {
            return $this->respond(
                [
                    'status' => FALSE,
                    'message' => 'Barang tidak ditemukan',
                    'result' => $result,
                ],
                200
            );
        }
    }


    // Ambil Semua Produk jika nilai get kosong
    public function index()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

        $model = new InventarisModel();
        if (!empty($search)) {
            $result = $model->like('nama', $search)->orderBy('id', 'DESC')->findAll();
        } else {
            $result = $model->orderBy('id', 'DESC')->findAll(10);
        }

        if (!empty($result)) {
            $data = [
                'status' => true,
                'data' => $result
            ];
        } else {
            $data = [
                'status' => false,
                'message' => 'Barang tidak ditemukan'
            ];
        }
        return $this->respond($data);
    }

    // create
    public function create()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods:POST");
        header('Content-Type: application/json');

        $id = $this->request->getPost('id');

        if (!empty($_FILES['image']['tmp_name'])) {
            $errors = array();
            $allowed_ext = array('jpg', 'jpeg', 'png',);
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            //$type = pathinfo($file_tmp, PATHINFO_EXTENSION);
            $type = 'jpeg';
            $data = file_get_contents($file_tmp);
            $tmp = explode('.', $_FILES['image']['name']);
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
                    'nama' => $this->request->getPost('nama'),
                    'harga' => $this->request->getPost('harga'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'img' => $base64,
                    'kategori' => $this->request->getPost('kategori'),
                ];
            } else {
                echo json_encode($errors);
            }
        } else {
            $data = [
                'nama' => $this->request->getPost('nama'),
                'harga' => $this->request->getPost('harga'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'kategori' => $this->request->getPost('kategori'),
            ];
        }

        $model = new InventarisModel();
        if (empty($id)) {
            $model->insert($data);
            $msg = "Data barang berhasil ditambahkan";
        } else {
            $model->update($id, $data);
            $msg = "Data barang berhasil diubah";
        }
        return $this->response->setJSON(['status' => true, 'message' => $msg]);
    }

    public function show($id = null)
    {
        header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

        $model = new InventarisModel();
        $data  = [
            'status' => true,
            'data' => $model->where('id', $id)->first()
        ];

        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }

    // delete
    public function delete($id = null)
    {
        $model = new InventarisModel();
        $data = $model->where('id', $id)->delete($id);
        if ($data) {
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data produk berhasil dihapus.'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }
}
