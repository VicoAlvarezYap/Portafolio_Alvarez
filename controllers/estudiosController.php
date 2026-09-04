<?php
// controllers/EstudiosController.php
require_once __DIR__ . '/../config/database.php';

class estudiosController {

    public function index() {
        global $pdo;

        $esAdmin = isset($_SESSION['username']) || (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true);

        if ($esAdmin && $_SERVER['REQUEST_METHOD'] === 'POST') { //pocesamos la peticion de administrador
            $this->handlePostActions($pdo);
        }

        $materiaEditar = null;
        $carreraEditar = null;

        if ($esAdmin) {
            $materiaEditar = $this->handleGetActions($pdo);
            $carreraEditar = $this->handleCarreraGetActions($pdo);
        }

        $carreras = $pdo->query("SELECT * FROM carreras ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
        $estados = $pdo->query("SELECT id, nombre FROM estados_materia ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);

        $sqlMaterias = "SELECT m.*, e.nombre AS estado_nombre 
                        FROM materias m 
                        LEFT JOIN estados_materia e ON m.estado_id = e.id ";
        if (!$esAdmin) {
            $sqlMaterias .= " WHERE m.activo = 1 ";
        }
        $sqlMaterias .= " ORDER BY m.anio ASC, m.cuatrimestre ASC, m.nombre ASC";

        $materias = $pdo->query($sqlMaterias)->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../views/estudios.php'; //pasa las variables a la vista de estudio
    }


    private function handlePostActions($pdo) {
        $accion = $_POST['accion'] ?? '';

        if ($accion === 'guardar_carrera') {
            $id     = filter_var($_POST['carrera_id'] ?? 0, FILTER_VALIDATE_INT);
            $nombre = trim($_POST['nombre_carrera'] ?? '');

            if (!empty($nombre)) {
                if ($id > 0) {
                    $stmt = $pdo->prepare("UPDATE carreras SET nombre = :nombre WHERE id = :id");
                    $stmt->execute([':nombre' => $nombre, ':id' => $id]);
                } else {
                    $stmt = $pdo->prepare("INSERT INTO carreras (nombre) VALUES (:nombre)");
                    $stmt->execute([':nombre' => $nombre]);
                }
                header("Location: index.php?action=estudios");
                exit();
            }
        }

  
        if ($accion === 'guardar_materia') { //crea materia
            $id           = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
            $nombre       = trim($_POST['nombre'] ?? '');
            $anio         = filter_var($_POST['anio'] ?? 1, FILTER_VALIDATE_INT);
            $cuatrimestre = filter_var($_POST['cuatrimestre'] ?? 0, FILTER_VALIDATE_INT);
            $estado_id    = filter_var($_POST['estado_id'] ?? 0, FILTER_VALIDATE_INT);
            $carrera_id   = filter_var($_POST['carrera_id'] ?? 1, FILTER_VALIDATE_INT);

            if (!empty($nombre) && in_array($cuatrimestre, [1, 2]) && $anio > 0 && $estado_id > 0) {
                if ($id > 0) {
                    $sql = "UPDATE materias SET nombre = :nombre, anio = :anio, cuatrimestre = :cuatrimestre, estado_id = :estado_id, carrera_id = :carrera_id WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':nombre'       => $nombre,
                        ':anio'         => $anio,
                        ':cuatrimestre' => $cuatrimestre,
                        ':estado_id'    => $estado_id,
                        ':carrera_id'   => $carrera_id,
                        ':id'           => $id
                    ]);
                } else {
                    $sqlInsert = "INSERT INTO materias (nombre, anio, cuatrimestre, estado_id, carrera_id, activo) VALUES (:nombre, :anio, :cuatrimestre, :estado_id, :carrera_id, 1)";
                    $stmtInsert = $pdo->prepare($sqlInsert);
                    $stmtInsert->execute([
                        ':nombre'       => $nombre,
                        ':anio'         => $anio,
                        ':cuatrimestre' => $cuatrimestre,
                        ':estado_id'    => $estado_id,
                        ':carrera_id'   => $carrera_id
                    ]);
                }
                header("Location: index.php?action=estudios");
                exit();
            }
        }

        // deplegable de estado
        if ($accion === 'cambiar_estado_materia') {
            $materia_id = filter_var($_POST['materia_id'] ?? 0, FILTER_VALIDATE_INT);
            $estado_id  = filter_var($_POST['estado_id'] ?? 0, FILTER_VALIDATE_INT);

            if ($materia_id > 0 && $estado_id > 0) {
                $stmt = $pdo->prepare("UPDATE materias SET estado_id = :estado_id WHERE id = :id");
                $stmt->execute([':estado_id' => $estado_id, ':id' => $materia_id]);
                header("Location: index.php?action=estudios");
                exit();
            }
        }
    }

  
    private function handleGetActions($pdo) {

        if (isset($_GET['toggle_materia'])) {
            $id = intval($_GET['toggle_materia']);
            $stmt = $pdo->prepare("UPDATE materias SET activo = NOT activo WHERE id = :id");
            $stmt->execute(['id' => $id]);
            header("Location: index.php?action=estudios");
            exit();
        }

        // borrar logico
        if (isset($_GET['action_type']) && $_GET['action_type'] === 'delete' && isset($_GET['id'])) {
            $idBorrar = filter_var($_GET['id'], FILTER_VALIDATE_INT);
            if ($idBorrar > 0) {
                $stmtDelete = $pdo->prepare("UPDATE materias SET activo = 0 WHERE id = :id");
                $stmtDelete->execute([':id' => $idBorrar]);
                header("Location: index.php?action=estudios");
                exit();
            }
        }

      
        if (isset($_GET['action_type']) && $_GET['action_type'] === 'edit' && isset($_GET['id'])) {
            $idEditar = filter_var($_GET['id'], FILTER_VALIDATE_INT);
            if ($idEditar > 0) {
                $stmtEdit = $pdo->prepare("SELECT * FROM materias WHERE id = :id");
                $stmtEdit->execute([':id' => $idEditar]);
                return $stmtEdit->fetch(PDO::FETCH_ASSOC);
            }
        }

        return null;
    }

  
    private function handleCarreraGetActions($pdo) { //carrera
        // Eliminar Carrera
        if (isset($_GET['action_carrera']) && $_GET['action_carrera'] === 'delete' && isset($_GET['carrera_id'])) {
            $idCarrera = filter_var($_GET['carrera_id'], FILTER_VALIDATE_INT);
            if ($idCarrera > 0) {
                $stmtDelete = $pdo->prepare("DELETE FROM carreras WHERE id = :id");
                $stmtDelete->execute([':id' => $idCarrera]);
                header("Location: index.php?action=estudios");
                exit();
            }
        }

        // edita las carreras
        if (isset($_GET['action_carrera']) && $_GET['action_carrera'] === 'edit' && isset($_GET['carrera_id'])) {
            $idCarreraEdit = filter_var($_GET['carrera_id'], FILTER_VALIDATE_INT);
            if ($idCarreraEdit > 0) {
                $stmtC = $pdo->prepare("SELECT * FROM carreras WHERE id = :id");
                $stmtC->execute([':id' => $idCarreraEdit]);
                return $stmtC->fetch(PDO::FETCH_ASSOC);
            }
        }

        return null;
    }
}