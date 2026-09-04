<?php
class user {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function getByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}