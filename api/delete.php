<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'POST' && $method !== 'DELETE') {
    http_response_code(405);
    echo json_encode(["error" => "Method harus POST atau DELETE"]);
    exit();
}

$input = json_decode(file_get_contents("php://input"), true);
if (!$input) $input = $_POST;

if (empty($input['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Parameter id wajib dikirim"]);
    exit();
}

$stmt = $pdo->prepare("DELETE FROM barang WHERE id = :id");
$stmt->execute([':id' => $input['id']]);

if ($stmt->rowCount() > 0) {
    echo json_encode(["status" => "success", "message" => "Barang dihapus"]);
} else {
    http_response_code(404);
    echo json_encode(["error" => "ID tidak ditemukan"]);
}
?>