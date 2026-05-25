<?php
class AuthController {
    private $userModel;
    public function __construct($db) { $this->userModel = new User($db); }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $remember = isset($_POST['remember']);
            $user = $this->userModel->findByUsername($username);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['id'];
                if ($remember) setcookie('remember_username', $user['username'], time()+86400*7, '/');
                else if (isset($_COOKIE['remember_username'])) setcookie('remember_username', '', time()-3600, '/');
                header("Location: index.php?url=barang/index");
                exit();
            } else header("Location: index.php?url=auth/login&error=1");
        }
        require_once __DIR__ . '/../views/auth/login.php';
    }
    
    public function register() {
        $error = ''; $success = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $confirm = $_POST['confirm_password'];
            if (empty($username) || empty($password)) $error = "Username dan password harus diisi.";
            elseif ($password !== $confirm) $error = "Konfirmasi password tidak cocok.";
            elseif ($this->userModel->usernameExists($username)) $error = "Username sudah terdaftar.";
            else {
                if ($this->userModel->create($username, $password)) $success = "Registrasi berhasil! Silakan login.";
                else $error = "Registrasi gagal.";
            }
        }
        require_once __DIR__ . '/../views/auth/register.php';
    }
    
    public function logout() {
        session_destroy();
        if (isset($_COOKIE['remember_username'])) setcookie('remember_username', '', time()-3600, '/');
        header("Location: index.php?url=auth/login&logout=1");
        exit();
    }
}
?>