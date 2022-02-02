<?php
include_once '../../../config/database.php';
include_once '../../model/opcionPregunta.php';

class OpcionesPreguntaService
{

    // Connection
    private $conn;

    // Table
    private $db_table = "opcion_pregunta";

    // Columns
    private $opcionPregunta;

    public function getOpcionPregunta()
    {
        return $this->opcionPregunta;
    }

    public function setOpcionPregunta($opcionPregunta)
    {
        try {
            $this->opcionPregunta->pregunta = $opcionPregunta->pregunta ??= 0;
            $this->opcionPregunta->nombre = $opcionPregunta->nombre ??= '';
        } catch (Exception $ex) {
            return;
        }
    }

    public function setIdOpcionPregunta($id)
    {
        $this->opcionPregunta->id = $id;
    }

    public function __construct()
    {
        $database = new Database();
        $this->opcionPregunta = new OpcionPregunta();
        $this->conn = $database->getConnection();
    }

    // GET ALL
    public function getOpcionesPregunta()
    {
        $sqlQuery = "SELECT id, pregunta, nombre FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createOpcionPregunta()
    {
        if ($this->opcionPregunta->nombre) {
            $sqlQuery = "INSERT INTO
                    " . $this->db_table . "
                SET
                    pregunta = :pregunta
                    nombre = :nombre
                    ";

            $stmt = $this->conn->prepare($sqlQuery);

            // sanitize
            $this->opcionPregunta->setPregunta(htmlspecialchars(strip_tags($this->opcionPregunta->getPregunta())));
            $this->opcionPregunta->setNombre(htmlspecialchars(strip_tags($this->opcionPregunta->getNombre())));

            // bind data
            $stmt->bindParam(":pregunta", $this->opcionPregunta->pregunta);
            $stmt->bindParam(":nombre", $this->opcionPregunta->nombre);

            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
        }
        return null;
    }

    // SINGLE ROL
    public function getSingleOpcionPregunta()
    {
        $sqlQuery = "SELECT
                    id, 
                    pregunta,
                    nombre
                  FROM
                    " . $this->db_table . "
                WHERE 
                   id = ?
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->opcionPregunta->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->opcionPregunta->setPregunta($dataRow['id'] ??= 0);
        $this->opcionPregunta->setPregunta($dataRow['pregunta'] ??= 0);
        $this->opcionPregunta->setNombre($dataRow['nombre'] ??= '');
    }

    // UPDATE
    public function updateOpcionPregunta()
    {
        $sqlQuery = "UPDATE
                    " . $this->db_table . "
                SET
                    pregunta = :pregunta,
                    nombre = :nombre
                WHERE 
                    id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->opcionPregunta->setPregunta(htmlspecialchars(strip_tags($this->opcionPregunta->getPregunta())));
        $this->opcionPregunta->setNombre(htmlspecialchars(strip_tags($this->opcionPregunta->getNombre())));
        $this->opcionPregunta->setId(htmlspecialchars(strip_tags($this->opcionPregunta->getId())));

        // bind data
        $stmt->bindParam(":pregunta", $this->opcionPregunta->pregunta);
        $stmt->bindParam(":nombre", $this->opcionPregunta->nombre);
        $stmt->bindParam(":id", $this->opcionPregunta->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deleteOpcionPregunta()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->opcionPregunta->setId(htmlspecialchars(strip_tags($this->opcionPregunta->getId())));

        $stmt->bindParam(1, $this->opcionPregunta->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
