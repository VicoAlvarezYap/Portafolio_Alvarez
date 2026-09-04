<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/carrera.php';
require_once __DIR__ . '/../models/materia.php';

class estudiosController {

    private $carreraModel;
    private $materiaModel;

    public function __construct() {
        global $pdo;
        $this->carreraModel = new carrera($pdo);
        $this->materiaModel = new materia($pdo);
    }

    public function index() {
        $esAdmin = isset($_SESSION['username']) || (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true);

        if ($esAdmin && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePostActions();
        }

        $materiaEditar = null;
        $carreraEditar = null;

        if ($esAdmin) {
            $materiaEditar = $this->handleGetActions();
            $carreraEditar = $this->handleCarreraGetActions();
        }

        $carreras = $this->carreraModel->getAll();
        $estados  = $this->materiaModel->getEstados();
        $materias = $this->materiaModel->getAll(!$esAdmin); // true = solo activas

        require_once __DIR__ . '/../views/estudios.php';
    }

    private function handlePostActions() {
        $accion = $_POST['accion'] ?? '';

        if ($accion === 'guardar_carrera') {
            $id     = filter_var($_POST['carrera_id'] ?? 0, FILTER_VALIDATE_INT);
            $nombre = trim($_POST['nombre_carrera'] ?? '');

            if (!empty($nombre)) {
                $this->carreraModel->guardar($id, $nombre);
                header("Location: index.php?action=estudios");
                exit();
            }
        }

        if ($accion === 'guardar_materia') {
            $id           = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
            $nombre       = trim($_POST['nombre'] ?? '');
            $anio         = filter_var($_POST['anio'] ?? 1, FILTER_VALIDATE_INT);
            $cuatrimestre = filter_var($_POST['cuatrimestre'] ?? 0, FILTER_VALIDATE_INT);
            $estado_id    = filter_var($_POST['estado_id'] ?? 0, FILTER_VALIDATE_INT);
            $carrera_id   = filter_var($_POST['carrera_id'] ?? 1, FILTER_VALIDATE_INT);

            if (!empty($nombre) && in_array($cuatrimestre, [1, 2]) && $anio > 0 && $estado_id > 0) {
                $data = compact('nombre', 'anio', 'cuatrimestre', 'estado_id', 'carrera_id');

                if ($id > 0) {
                    $this->materiaModel->update($id, $data);
                } else {
                    $this->materiaModel->create($data);
                }
                header("Location: index.php?action=estudios");
                exit();
            }
        }

        if ($accion === 'cambiar_estado_materia') {
            $materia_id = filter_var($_POST['materia_id'] ?? 0, FILTER_VALIDATE_INT);
            $estado_id  = filter_var($_POST['estado_id'] ?? 0, FILTER_VALIDATE_INT);

            if ($materia_id > 0 && $estado_id > 0) {
                $this->materiaModel->cambiarEstado($materia_id, $estado_id);
                header("Location: index.php?action=estudios");
                exit();
            }
        }
    }

    private function handleGetActions() {
        if (isset($_GET['toggle_materia'])) {
            $this->materiaModel->toggleActivo(intval($_GET['toggle_materia']));
            header("Location: index.php?action=estudios");
            exit();
        }

        if (isset($_GET['action_type']) && $_GET['action_type'] === 'delete' && isset($_GET['id'])) {
            $idBorrar = filter_var($_GET['id'], FILTER_VALIDATE_INT);
            if ($idBorrar > 0) {
                $this->materiaModel->desactivar($idBorrar);
                header("Location: index.php?action=estudios");
                exit();
            }
        }

        if (isset($_GET['action_type']) && $_GET['action_type'] === 'edit' && isset($_GET['id'])) {
            $idEditar = filter_var($_GET['id'], FILTER_VALIDATE_INT);
            if ($idEditar > 0) {
                return $this->materiaModel->getById($idEditar);
            }
        }

        return null;
    }

    private function handleCarreraGetActions() {
        if (isset($_GET['action_carrera']) && $_GET['action_carrera'] === 'delete' && isset($_GET['carrera_id'])) {
            $idCarrera = filter_var($_GET['carrera_id'], FILTER_VALIDATE_INT);
            if ($idCarrera > 0) {
                $this->carreraModel->delete($idCarrera);
                header("Location: index.php?action=estudios");
                exit();
            }
        }

        if (isset($_GET['action_carrera']) && $_GET['action_carrera'] === 'edit' && isset($_GET['carrera_id'])) {
            $idCarreraEdit = filter_var($_GET['carrera_id'], FILTER_VALIDATE_INT);
            if ($idCarreraEdit > 0) {
                return $this->carreraModel->getById($idCarreraEdit);
            }
        }

        return null;
    }
}