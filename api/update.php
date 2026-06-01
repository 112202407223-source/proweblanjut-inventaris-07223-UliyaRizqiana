<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method harus POST"]);
    exit();
}

$input = json_decode(file_get_contents("php://input"), true);
if (!$input) $input = $_POST;

if (empty($input['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Parameter id wajib dikirim"]);
    exit();
}

$id = $input['id'];
$fields = [];
$params = [':id' => $id];

if (isset($input['nama_barang'])) {
    $fields[] = "nama_barang = :nama";
    $params[':nama'] = $input['nama_barang'];
}
if (isset($input['jumlah'])) {
    $fields[] = "jumlah = :jumlah";
    $params[':jumlah'] = $input['jumlah'];
}
if (isset($input['harga'])) {
    $fields[] = "harga = :harga";
    $params[':harga'] = $input['harga'];
}
if (isset($input['tanggal_masuk'])) {
    $fields[] = "tanggal_masuk = :tgl";
    $params[':tgl'] = $input['tanggal_masuk'];
}

if (count($fields) == 0) {
    http_response_code(400);
    echo json_encode(["error" => "Tidak ada field yang akan diupdate"]);
    exit();
}

$sql = "UPDATE barang SET " . implode(", ", $fields) . " WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

if ($stmt->rowCount() > 0) {
    echo json_encode(["status" => "success", "message" => "Barang berhasil diupdate"]);
} else {
    echo json_encode(["status" => "info", "message" => "Tidak ada perubahan atau ID tidak ditemukan"]);
}
?>