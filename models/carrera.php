<?php
class carrera {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM carreras ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM carreras WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function guardar($id, $nombre) {
        if ($id > 0) {
            $stmt = $this->db->prepare("UPDATE carreras SET nombre = :nombre WHERE id = :id");
            return $stmt->execute([':nombre' => $nombre, ':id' => $id]);
        }
        $stmt = $this->db->prepare("INSERT INTO carreras (nombre) VALUES (:nombre)");
        return $stmt->execute([':nombre' => $nombre]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM carreras WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}