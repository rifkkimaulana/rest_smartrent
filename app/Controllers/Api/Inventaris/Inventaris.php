<?php

namespace App\Controllers\Api\Inventaris;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\InventarisModel;
use App\Models\KategoriModel;

class Inventaris extends ResourceController
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

        $produkModel = new InventarisModel();
        $produk = $produkModel->fetch_data($limit, $start, $search, $namaKategori);

        $rowCount = $produkModel->countAllResults();

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

    public function index()
    {
        $InventarisModel = new InventarisModel();

        $dataInventaris = $InventarisModel->orderBy('id', 'DESC')->findAll();
        if ($dataInventaris) {
            $data = [
                'status' => 200,
                'data' => $dataInventaris
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Inventaris Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function create()
    {
        $InventarisModel = new InventarisModel();

        $id = $this->request->getVar('id');

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
                    'nama_barang' =>  $this->request->getVar('nama_inventaris'),
                    'kategori_id' => $this->request->getVar('kategori_id'),
                    'deskripsi' => $this->request->getVar('deskripsi'),
                    'harga_sewa' => $this->request->getVar('harga_sewa'),
                    'stok' => $this->request->getVar('stok'),
                    'gambar' => $base64,
                    'durasi_sewa' => $this->request->getVar('durasi_sewa'),
                    'status' => $this->request->getVar('status'),
                    'informasi_tambahan' => $this->request->getVar('keterangan_tambahan'),
                ];
            }
        } else {
            $data = [
                'nama_barang' =>  $this->request->getVar('nama_inventaris'),
                'kategori_id' => $this->request->getVar('kategori_id'),
                'deskripsi' => $this->request->getVar('deskripsi'),
                'harga_sewa' => $this->request->getVar('harga_sewa'),
                'stok' => $this->request->getVar('stok'),
                'durasi_sewa' => $this->request->getVar('durasi_sewa'),
                'status' => $this->request->getVar('status'),
                'informasi_tambahan' => $this->request->getVar('keterangan_tambahan'),
            ];
        }
        if (empty($id)) {
            if ($InventarisModel->insert($data)) {
                $data = [
                    'status'   => 201,
                    'data' => [
                        'messages' => 'Inventaris Berhasil ditambahkan!'
                    ]
                ];
            } else {
                $data = [
                    'status'   => 400,
                    'data' => [
                        'messages' => 'Inventaris Gagal ditambahkan!'
                    ]
                ];
            }
        } else {
            if ($InventarisModel->update($id, $data)) {
                $data = [
                    'status'   => 201,
                    'data' => [
                        'messages' => 'Inventaris Berhasil diubah!'
                    ]
                ];
            } else {
                $data = [
                    'status'   => 500,
                    'data' => [
                        'messages' => 'Inventaris Gagal diubah!'
                    ]
                ];
            }
        }

        return $this->respond($data);
    }

    public function show($id = null)
    {
        $InventarisModel = new InventarisModel();
        $data = $InventarisModel->where('id', $id)->first();
        if ($data) {

            $data = [
                'status' => 200,
                'data' => [$data]
            ];
        } else {
            $data = [
                'status' => 404,
                'data' => [
                    'messages' => 'Inventaris Tidak Tersedia'
                ]
            ];
        }
        return $this->respond($data);
    }

    public function delete($id = null)
    {
        $InventarisModel = new InventarisModel();
        $data = $InventarisModel->where('id', $id)->first();

        if ($data) {
            if ($InventarisModel->delete($id)) {
                $data = [
                    'status'   => 204,
                    'success' => [
                        'messages' => 'Data Inventaris berhasil dihapus.'
                    ]
                ];
            } else {
                $data = [
                    'status'   => 500,
                    'error' => [
                        'messages' => 'Kesalahan sistem tidak dapat menghapus Inventaris terpilih.'
                    ]
                ];
            }
        } else {
            $data = [
                'status'   => 404,
                'error' => [
                    'messages' => 'Data Inventaris Tidak Tersedia.'
                ]
            ];
        }
        return $this->respond($data);
    }
}
