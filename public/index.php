<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Barang.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/BarangController.php';

$url = isset($_GET['url']) ? $_GET['url'] : 'barang/index';
$urlParts = explode('/', $url);
$controllerName = ucfirst($urlParts[0]) . 'Controller';
$method = isset($urlParts[1]) ? $urlParts[1] : 'index';

switch ($controllerName) {
    case 'AuthController': $controller = new AuthController($db); break;
    case 'BarangController': $controller = new BarangController($db); break;
    default: http_response_code(404); echo "404 - Halaman tidak ditemukan"; exit();
}
if (method_exists($controller, $method)) $controller->$method();
else { http_response_code(404); echo "404 - Method tidak ditemukan"; }
?>