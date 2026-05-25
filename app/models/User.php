<?php
class User {
    private $db;
    public function __construct($db) { $this->db = $db; }
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT id, username, password FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch();
    }
    public function create($username, $password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $hashed]);
    }
    public function usernameExists($username) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch() ? true : false;
    }
}
?>