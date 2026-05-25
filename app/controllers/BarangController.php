<?php
class BarangController {
    private $model;
    public function __construct($db) { $this->model = new Barang($db); }
    
    private function isLoggedIn() {
        if (!isset($_SESSION['username'])) {
            header("Location: index.php?url=auth/login");
            exit();
        }
    }
    
    public function index() {
        $this->isLoggedIn();
        $data = $this->model->getAll();
        require_once __DIR__ . '/../views/barang/index.php';
    }
    
    public function tambah() {
        $this->isLoggedIn();
        $errors = [];
        $old_input = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama_barang = trim($_POST['nama_barang'] ?? '');
            $kategori = trim($_POST['kategori'] ?? '');
            $jumlah = trim($_POST['jumlah'] ?? '');
            $harga = trim($_POST['harga'] ?? '');
            $supplier = trim($_POST['supplier'] ?? '');
            $tanggal_masuk = $_POST['tanggal_masuk'] ?? '';
            $stok_minimum = trim($_POST['stok_minimum'] ?? '');
            $keterangan = trim($_POST['keterangan'] ?? '');
            $old_input = compact('nama_barang','kategori','jumlah','harga','supplier','tanggal_masuk','stok_minimum','keterangan');
            
            if (empty($nama_barang)) $errors[] = "Nama barang harus diisi.";
            if (!is_numeric($jumlah) || $jumlah < 0) $errors[] = "Jumlah harus angka positif.";
            if (!is_numeric($harga) || $harga < 0) $errors[] = "Harga harus angka positif.";
            if (empty($tanggal_masuk)) $errors[] = "Tanggal masuk harus diisi.";
            
            $gambar_name = null;
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                $file_tmp = $_FILES['gambar']['tmp_name'];
                $file_size = $_FILES['gambar']['size'];
                $file_ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg','jpeg','png'];
                if (!in_array($file_ext, $allowed)) $errors[] = "Format gambar harus JPG, JPEG, atau PNG.";
                if ($file_size > 1*1024*1024) $errors[] = "Ukuran gambar maksimal 1MB.";
                if (empty($errors)) {
                    if (!is_dir(__DIR__ . '/../../public/uploads/')) mkdir(__DIR__ . '/../../public/uploads/', 0777, true);
                    $gambar_name = uniqid() . '.' . $file_ext;
                    $upload_path = __DIR__ . '/../../public/uploads/' . $gambar_name;
                    if (!move_uploaded_file($file_tmp, $upload_path)) {
                        $errors[] = "Gagal mengunggah gambar.";
                        $gambar_name = null;
                    }
                }
            }
            
            if (empty($errors)) {
                $data = compact('nama_barang','kategori','jumlah','harga','supplier','tanggal_masuk','stok_minimum','keterangan');
                $data['gambar'] = $gambar_name;
                if ($this->model->create($data)) {
                    header("Location: index.php?url=barang/index&message=Data berhasil ditambahkan");
                    exit();
                } else $errors[] = "Gagal menyimpan ke database.";
            }
        }
        require_once __DIR__ . '/../views/barang/tambah.php';
    }
    
    public function edit() {
        $this->isLoggedIn();
        if (!isset($_GET['id'])) { header("Location: index.php?url=barang/index"); exit(); }
        $id = $_GET['id'];
        $barang = $this->model->getById($id);
        if (!$barang) { header("Location: index.php?url=barang/index&error=Data tidak ditemukan"); exit(); }
        $errors = [];
        $old_input = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama_barang = trim($_POST['nama_barang'] ?? '');
            $kategori = trim($_POST['kategori'] ?? '');
            $jumlah = trim($_POST['jumlah'] ?? '');
            $harga = trim($_POST['harga'] ?? '');
            $supplier = trim($_POST['supplier'] ?? '');
            $tanggal_masuk = $_POST['tanggal_masuk'] ?? '';
            $stok_minimum = trim($_POST['stok_minimum'] ?? '');
            $keterangan = trim($_POST['keterangan'] ?? '');
            $old_input = compact('nama_barang','kategori','jumlah','harga','supplier','tanggal_masuk','stok_minimum','keterangan');
            
            if (empty($nama_barang)) $errors[] = "Nama barang harus diisi.";
            if (!is_numeric($jumlah) || $jumlah < 0) $errors[] = "Jumlah harus angka positif.";
            if (!is_numeric($harga) || $harga < 0) $errors[] = "Harga harus angka positif.";
            if (empty($tanggal_masuk)) $errors[] = "Tanggal masuk harus diisi.";
            
            $gambar_baru = $barang['gambar'];
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                $file_tmp = $_FILES['gambar']['tmp_name'];
                $file_size = $_FILES['gambar']['size'];
                $file_ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg','jpeg','png'];
                if (!in_array($file_ext, $allowed)) $errors[] = "Format gambar harus JPG, JPEG, atau PNG.";
                if ($file_size > 1*1024*1024) $errors[] = "Ukuran gambar maksimal 1MB.";
                if (empty($errors)) {
                    $gambar_baru = uniqid() . '.' . $file_ext;
                    $upload_path = __DIR__ . '/../../public/uploads/' . $gambar_baru;
                    if (move_uploaded_file($file_tmp, $upload_path)) {
                        if ($barang['gambar'] && file_exists(__DIR__ . '/../../public/uploads/' . $barang['gambar'])) {
                            unlink(__DIR__ . '/../../public/uploads/' . $barang['gambar']);
                        }
                    } else {
                        $errors[] = "Gagal mengunggah gambar.";
                        $gambar_baru = $barang['gambar'];
                    }
                }
            }
            
            if (empty($errors)) {
                $data = compact('nama_barang','kategori','jumlah','harga','supplier','tanggal_masuk','stok_minimum','keterangan');
                $data['gambar'] = $gambar_baru;
                if ($this->model->update($id, $data)) {
                    header("Location: index.php?url=barang/index&message=Data berhasil diupdate");
                    exit();
                } else $errors[] = "Gagal mengupdate data.";
            }
        }
        require_once __DIR__ . '/../views/barang/edit.php';
    }
    
    public function hapus() {
        $this->isLoggedIn();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];
            $barang = $this->model->getById($id);
            if ($barang) {
                if ($barang['gambar'] && file_exists(__DIR__ . '/../../public/uploads/' . $barang['gambar'])) {
                    unlink(__DIR__ . '/../../public/uploads/' . $barang['gambar']);
                }
                if ($this->model->delete($id)) header("Location: index.php?url=barang/index&message=Data berhasil dihapus");
                else header("Location: index.php?url=barang/index&error=Gagal menghapus");
            } else header("Location: index.php?url=barang/index&error=Data tidak ditemukan");
        } else header("Location: index.php?url=barang/index");
        exit();
    }
}
?>