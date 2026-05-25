<?php
class Barang {
    private $db;
    public function __construct($db) { $this->db = $db; }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM barang ORDER BY id DESC");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM barang WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $sql = "INSERT INTO barang (nama_barang, kategori, jumlah, harga, supplier, tanggal_masuk, stok_minimum, keterangan, gambar) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['nama_barang'], $data['kategori'], $data['jumlah'], $data['harga'], 
            $data['supplier'], $data['tanggal_masuk'], $data['stok_minimum'], $data['keterangan'], $data['gambar']
        ]);
    }
    
    public function update($id, $data) {
        $sql = "UPDATE barang SET nama_barang=?, kategori=?, jumlah=?, harga=?, supplier=?, 
                tanggal_masuk=?, stok_minimum=?, keterangan=?, gambar=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['nama_barang'], $data['kategori'], $data['jumlah'], $data['harga'], 
            $data['supplier'], $data['tanggal_masuk'], $data['stok_minimum'], $data['keterangan'], $data['gambar'], $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM barang WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>