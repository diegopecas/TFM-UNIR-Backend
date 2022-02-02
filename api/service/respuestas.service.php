<?php
include_once '../../../config/database.php';
include_once '../../model/respuesta.php';

class RespuestasService
{

    // Connection
    private $conn;

    // Table
    private $db_table = "respuesta";

    // Columns
    private $respuesta;

    public function getRespuesta()
    {
        return $this->respuesta;
    }

    public function setRespuesta($respuesta)
    {
        try {
            $this->respuesta->pregunta = $respuesta->pregunta ??= 0;
            $this->respuesta->respuesta = $respuesta->respuesta ??= '';
            $this->respuesta->evaluacion = $respuesta->evaluacion ??= '';
            $this->respuesta->observacion = $respuesta->observacion ??= '';
            $this->respuesta->ejecucion = $respuesta->ejecucion ??= 0;
        } catch (Exception $ex) {
            return;
        }
    }

    public function setIdRespuesta($id)
    {
        $this->rol->id = $id;
    }

    public function __construct()
    {
        $database = new Database();
        $this->respuesta = new Respuesta();
        $this->conn = $database->getConnection();
    }

    // GET ALL
    public function getRespuestas()
    {
        $sqlQuery = "SELECT id, pregunta, respuesta, evaluacion, observacion, ejecucion FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createRespuesta()
    {
        if ($this->respuesta->pregunta) {
            $sqlQuery = "INSERT INTO
                    " . $this->db_table . "
                SET
                    pregunta = :pregunta
                    respuesta = :respuesta
                    evaluacion = :evaluacion
                    observacion = :observacion
                    ejecucion = :ejecucion
                    ";

            $stmt = $this->conn->prepare($sqlQuery);

            // sanitize
            $this->respuesta->setPregunta(htmlspecialchars(strip_tags($this->respuesta->getPregunta())));
            $this->respuesta->setRespuesta(htmlspecialchars(strip_tags($this->respuesta->getRespuesta())));
            $this->respuesta->setEvaluacion(htmlspecialchars(strip_tags($this->respuesta->getEvaluacion())));
            $this->respuesta->setObservacion(htmlspecialchars(strip_tags($this->respuesta->getObservacion())));
            $this->respuesta->setEjecucion(htmlspecialchars(strip_tags($this->respuesta->getEjecucion())));

            // bind data
            $stmt->bindParam(":pregunta", $this->respuesta->pregunta);
            $stmt->bindParam(":respuesta", $this->respuesta->respuesta);
            $stmt->bindParam(":evaluacion", $this->respuesta->evaluacion);
            $stmt->bindParam(":observacion", $this->respuesta->observacion);
            $stmt->bindParam(":ejecucion", $this->respuesta->ejecucion);

            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
        }
        return null;
    }

    // SINGLE ROL
    public function getSingleRespuesta()
    {
        $sqlQuery = "SELECT
                    id, 
                    pregunta, 
                    respuesta, 
                    evaluacion, 
                    observacion, 
                    ejecucion
                  FROM
                    " . $this->db_table . "
                WHERE 
                   id = ?
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->respuesta->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->respuesta->setPregunta($dataRow['pregunta'] ??= 0);
        $this->respuesta->setRespuesta($dataRow['respuesta'] ??= '');
        $this->respuesta->setEvaluacion($dataRow['evaluacion'] ??= '');
        $this->respuesta->setObservacion($dataRow['observacion'] ??= '');
        $this->respuesta->setEjecucion($dataRow['ejecucion'] ??= 0);
    }

    // UPDATE
    public function updateRespuesta()
    {
        $sqlQuery = "UPDATE
                    " . $this->db_table . "
                SET
                    pregunta = :pregunta,
                    respuesta = :respuesta,
                    evaluacion = :evaluacion,
                    observacion = :observacion,
                    ejecucion = :ejecucion
                WHERE 
                    id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->respuesta->setPregunta(htmlspecialchars(strip_tags($this->respuesta->getPregunta())));
        $this->respuesta->setRespuesta(htmlspecialchars(strip_tags($this->respuesta->getRespuesta())));
        $this->respuesta->setEvaluacion(htmlspecialchars(strip_tags($this->respuesta->getEvaluacion())));
        $this->respuesta->setObservacion(htmlspecialchars(strip_tags($this->respuesta->getObservacion())));
        $this->respuesta->setEjecucion(htmlspecialchars(strip_tags($this->respuesta->getEjecucion())));
        $this->respuesta->setId(htmlspecialchars(strip_tags($this->respuesta->getId())));

        // bind data
        $stmt->bindParam(":pregunta", $this->respuesta->pregunta);
        $stmt->bindParam(":respuesta", $this->respuesta->respuesta);
        $stmt->bindParam(":evaluacion", $this->respuesta->evaluacion);
        $stmt->bindParam(":observacion", $this->respuesta->observacion);
        $stmt->bindParam(":ejecucion", $this->respuesta->ejecucion);
        $stmt->bindParam(":id", $this->respuesta->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deleteRespuesta()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->respuesta->setId(htmlspecialchars(strip_tags($this->respuesta->getId())));

        $stmt->bindParam(1, $this->respuesta->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
