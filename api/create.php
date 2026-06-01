<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method harus POST"]);
    exit();
}

$input = json_decode(file_get_contents("php://input"), true);
if (!$input) $input = $_POST;

if (empty($input['nama_barang']) || empty($input['jumlah']) || empty($input['harga']) || empty($input['tanggal_masuk'])) {
    http_response_code(400);
    echo json_encode(["error" => "Semua field harus diisi: nama_barang, jumlah, harga, tanggal_masuk"]);
    exit();
}

$sql = "INSERT INTO barang (nama_barang, jumlah, harga, tanggal_masuk) VALUES (:nama, :jumlah, :harga, :tgl)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nama' => $input['nama_barang'],
    ':jumlah' => $input['jumlah'],
    ':harga' => $input['harga'],
    ':tgl' => $input['tanggal_masuk']
]);

http_response_code(201);
echo json_encode(["status" => "success", "message" => "Barang ditambahkan", "id" => $pdo->lastInsertId()]);
?>