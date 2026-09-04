<?php
class materia {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function getAll($soloActivas = false) {
        $query = "SELECT m.*, e.nombre AS estado_nombre 
                  FROM materias m 
                  LEFT JOIN estados_materia e ON m.estado_id = e.id ";
        if ($soloActivas) {
            $query .= " WHERE m.activo = 1 ";
        }
        $query .= " ORDER BY m.anio ASC, m.cuatrimestre ASC, m.nombre ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEstados() {
        $stmt = $this->db->prepare("SELECT id, nombre FROM estados_materia ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM materias WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO materias (nombre, anio, cuatrimestre, estado_id, carrera_id, activo) 
                  VALUES (:nombre, :anio, :cuatrimestre, :estado_id, :carrera_id, 1)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':nombre'       => $data['nombre'],
            ':anio'         => $data['anio'],
            ':cuatrimestre' => $data['cuatrimestre'],
            ':estado_id'    => $data['estado_id'],
            ':carrera_id'   => $data['carrera_id'],
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE materias SET nombre = :nombre, anio = :anio, cuatrimestre = :cuatrimestre, 
                  estado_id = :estado_id, carrera_id = :carrera_id WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':id'           => $id,
            ':nombre'       => $data['nombre'],
            ':anio'         => $data['anio'],
            ':cuatrimestre' => $data['cuatrimestre'],
            ':estado_id'    => $data['estado_id'],
            ':carrera_id'   => $data['carrera_id'],
        ]);
    }

    public function cambiarEstado($id, $estado_id) {
        $stmt = $this->db->prepare("UPDATE materias SET estado_id = :estado_id WHERE id = :id");
        return $stmt->execute([':estado_id' => $estado_id, ':id' => $id]);
    }

    public function toggleActivo($id) {
        $stmt = $this->db->prepare("UPDATE materias SET activo = NOT activo WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function desactivar($id) {
        $stmt = $this->db->prepare("UPDATE materias SET activo = 0 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM materias WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getByCarrera($carrera_id) {
        $query = "SELECT m.*, e.nombre AS estado_nombre 
                  FROM materias m 
                  LEFT JOIN estados_materia e ON m.estado_id = e.id 
                  WHERE m.carrera_id = :carrera_id 
                  ORDER BY m.anio ASC, m.nombre ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':carrera_id', $carrera_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}