<?php
require_once __DIR__ . '/../config/database.php';

class materia {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Obtiene todas las materias unidas a su estado
    public function getAll() {
        $query = "SELECT m.*, e.nombre AS estado_nombre 
                  FROM materias m 
                  LEFT JOIN estado_materia e ON m.estado_id = e.id 
                  ORDER BY m.anio ASC, m.nombre ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM materias WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO materias (nombre, anio, estado_id, nota) VALUES (:nombre, :anio, :estado_id, :nota)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':nombre'    => $data['nombre'],
            ':anio'      => $data['anio'],
            ':estado_id' => $data['estado_id'],
            ':nota'      => !empty($data['nota']) ? $data['nota'] : null
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE materias SET nombre = :nombre, anio = :anio, estado_id = :estado_id, nota = :nota WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':id'        => $id,
            ':nombre'    => $data['nombre'],
            ':anio'      => $data['anio'],
            ':estado_id' => $data['estado_id'],
            ':nota'      => !empty($data['nota']) ? $data['nota'] : null
        ]);
    }

    public function delete($id) {
        $query = "DELETE FROM materias WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getByCarrera($carrera_id) {
    $query = "SELECT m.*, e.nombre AS estado_nombre 
              FROM materias m 
              LEFT JOIN estado_materia e ON m.estado_id = e.id 
              WHERE m.carrera_id = :carrera_id 
              ORDER BY m.anio ASC, m.nombre ASC";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':carrera_id', $carrera_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}