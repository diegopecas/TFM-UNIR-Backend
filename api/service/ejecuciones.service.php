<?php
include_once '../../../config/database.php';
include_once '../../model/ejecucion.php';

class EjecucionesService
{

    // Connection
    private $conn;

    // Table
    private $db_table = "ejecucion";

    // Columns
    private $ejecucion;

    public function getEjecucion()
    {
        return $this->ejecucion;
    }

    public function setEjecucion($ejecucion)
    {
        try {
            $this->ejecucion->prueba = $ejecucion->prueba ??= 0;
            $this->ejecucion->evaluacion = $ejecucion->evaluacion ??= 0;
            $this->ejecucion->observacion = $ejecucion->observacion ??= '';
            $this->ejecucion->usuario = $ejecucion->usuario ??= 0;
            $this->ejecucion->fecha = $ejecucion->fecha ??= '';
        } catch (Exception $ex) {
            return;
        }
    }

    public function setIdEjecucion($id)
    {
        $this->ejecucion->id = $id;
    }

    public function __construct()
    {
        $database = new Database();
        $this->ejecucion = new Ejecucion();
        $this->conn = $database->getConnection();
    }

    // GET ALL
    public function getEjecuciones()
    {
        $sqlQuery = "SELECT id, prueba, evaluacion, observacion, usuario, fecha FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createEjecucion()
    {
        if ($this->ejecucion->prueba) {
            $sqlQuery = "INSERT INTO
                    " . $this->db_table . "
                SET
                    prueba = :prueba,
                    evaluacion = :evaluacion,
                    observacion = :observacion,
                    usuario = :usuario,
                    fecha = :fecha
                    ";

            $stmt = $this->conn->prepare($sqlQuery);

            // sanitize
            $this->ejecucion->setPrueba(htmlspecialchars(strip_tags($this->ejecucion->getPrueba())));
            $this->ejecucion->setEvaluacion(htmlspecialchars(strip_tags($this->ejecucion->getEvaluacion())));
            $this->ejecucion->setObservacion(htmlspecialchars(strip_tags($this->ejecucion->getObservacion())));
            $this->ejecucion->setUsuario(htmlspecialchars(strip_tags($this->ejecucion->getUsuario())));
            $this->ejecucion->setFecha(htmlspecialchars(strip_tags($this->ejecucion->getFecha())));

            // bind data
            $stmt->bindParam(":prueba", $this->ejecucion->prueba);
            $stmt->bindParam(":evaluacion", $this->ejecucion->evaluacion);
            $stmt->bindParam(":observacion", $this->ejecucion->observacion);
            $stmt->bindParam(":usuario", $this->ejecucion->usuario);
            $stmt->bindParam(":fecha", $this->ejecucion->fecha);

            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
        }
        return null;
    }

    // SINGLE ROL
    public function getSingleEjecucion()
    {
        $sqlQuery = "SELECT
                    id, 
                    prueba,
                    evaluacion,
                    observacion,
                    usuario,
                    fecha
                  FROM
                    " . $this->db_table . "
                WHERE 
                   id = ?
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->ejecucion->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->rol->setId($dataRow['id'] ??= 0);
        $this->ejecucion->setPrueba($dataRow['prueba'] ??= 0);
        $this->ejecucion->setEvaluacion($dataRow['evaluacion'] ??= '');
        $this->ejecucion->setObservacion($dataRow['observacion'] ??= '');
        $this->ejecucion->setUsuario($dataRow['usuario'] ??= 0);
        $this->ejecucion->setFecha($dataRow['fecha'] ??= '');
    }

    // UPDATE
    public function updateEjecucion()
    {
        if ($this->ejecucion->prueba) {
            $sqlQuery = "UPDATE
                    " . $this->db_table . "
                SET
                    prueba = :prueba
                    evaluacion = :evaluacion
                    observacion = :observacion
                    usuario = :usuario
                    fecha = :fecha
                WHERE 
                    id = :id";

            $stmt = $this->conn->prepare($sqlQuery);

            $this->ejecucion->setPrueba(htmlspecialchars(strip_tags($this->ejecucion->getPrueba())));
            $this->ejecucion->setEvaluacion(htmlspecialchars(strip_tags($this->ejecucion->getEvaluacion())));
            $this->ejecucion->setObservacion(htmlspecialchars(strip_tags($this->ejecucion->getObservacion())));
            $this->ejecucion->setUsuario(htmlspecialchars(strip_tags($this->ejecucion->getUsuario())));
            $this->ejecucion->setFecha(htmlspecialchars(strip_tags($this->ejecucion->getFecha())));
            $this->ejecucion->setId(htmlspecialchars(strip_tags($this->ejecucion->getId())));

            // bind data
            $stmt->bindParam(":prueba", $this->ejecucion->prueba);
            $stmt->bindParam(":evaluacion", $this->ejecucion->evaluacion);
            $stmt->bindParam(":observacion", $this->ejecucion->observacion);
            $stmt->bindParam(":usuario", $this->ejecucion->usuario);
            $stmt->bindParam(":fecha", $this->ejecucion->fecha);
            $stmt->bindParam(":id", $this->ejecucion->id);

            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    // DELETE
    function deleteEjecucion()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->ejecucion->setId(htmlspecialchars(strip_tags($this->ejecucion->getId())));

        $stmt->bindParam(1, $this->ejecucion->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
