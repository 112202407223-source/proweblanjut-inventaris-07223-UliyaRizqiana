<?php
require_once 'config.php';

$stmt = $pdo->query("SELECT * FROM barang ORDER BY id DESC");
$barang = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($barang);
?>