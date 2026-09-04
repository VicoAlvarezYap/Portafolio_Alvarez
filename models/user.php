<?php
class user {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    // Buscar un usuario por su nombre de usuario
    public function getByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}