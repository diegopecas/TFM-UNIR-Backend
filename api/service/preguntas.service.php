<?php
include_once '../../../config/database.php';
include_once '../../model/pregunta.php';

class PreguntasService
{

    // Connection
    private $conn;

    // Table
    private $db_table = "pregunta";

    // Columns
    private $pregunta;

    public function getPregunta()
    {
        return $this->pregunta;
    }

    public function setPregunta($pregunta)
    {
        try {
            $this->pregunta->paso = $pregunta->paso ??= 0;
            $this->pregunta->nombre = $pregunta->nombre ??= '';
            $this->pregunta->tipo = $pregunta->tipo ??= '';
            $this->pregunta->opciones = $pregunta->opciones ??= '';
        } catch (Exception $ex) {
            return;
        }
    }

    public function setIdPregunta($id)
    {
        $this->pregunta->id = $id;
    }

    public function __construct()
    {
        $database = new Database();
        $this->pregunta = new Pregunta();
        $this->conn = $database->getConnection();
    }

    // GET ALL
    public function getPreguntas()
    {
        $sqlQuery = "SELECT id, paso, nombre, tipo, opciones FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    
    public function getPreguntasByPaso($paso)
    {
        $sqlQuery = "SELECT
                        id, 
                        paso,
                        nombre,
                        tipo,
                        opciones
                    FROM
                        " . $this->db_table . "
                    WHERE 
                    paso = :paso";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(":paso", $paso);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createPregunta()
    {
        if ($this->pregunta->nombre) {
            $sqlQuery = "INSERT INTO
                    " . $this->db_table . "
                SET
                    paso = :paso,
                    nombre = :nombre,
                    tipo = :tipo,
                    opciones = :opciones
                    ";
            $stmt = $this->conn->prepare($sqlQuery);

            // sanitize
            $this->pregunta->paso=htmlspecialchars(strip_tags($this->pregunta->paso));
            $this->pregunta->nombre=htmlspecialchars(strip_tags($this->pregunta->nombre));
            $this->pregunta->tipo=htmlspecialchars(strip_tags($this->pregunta->tipo));
            $this->pregunta->opciones=htmlspecialchars(strip_tags($this->pregunta->opciones));

            // bind data
            $stmt->bindParam(":paso", $this->pregunta->paso);
            $stmt->bindParam(":nombre", $this->pregunta->nombre);
            $stmt->bindParam(":tipo", $this->pregunta->tipo);
            $stmt->bindParam(":opciones", $this->pregunta->opciones);

            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
        }
        return null;
    }

    // SINGLE ROL
    public function getSinglePregunta()
    {
        $sqlQuery = "SELECT
                    id, 
                    paso,
                    nombre,
                    tipo,
                    opciones 
                  FROM
                    " . $this->db_table . "
                WHERE 
                   id = ?
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->pregunta->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->pregunta->setId($dataRow['id'] ??= 0);
        $this->pregunta->setPaso($dataRow['paso'] ??= 0);
        $this->pregunta->setNombre($dataRow['nombre'] ??= '');
        $this->pregunta->setTipo($dataRow['tipo'] ??= '');
        $this->pregunta->setOpciones($dataRow['opciones'] ??= '');
    }

    // UPDATE
    public function updatePregunta()
    {
        $sqlQuery = "UPDATE
                    " . $this->db_table . "
                SET
                    paso = :paso,
                    nombre = :nombre,
                    tipo = :tipo,
                    opciones = :opciones
                WHERE 
                    id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->pregunta->setPaso(htmlspecialchars(strip_tags($this->pregunta->getPaso())));
        $this->pregunta->setNombre(htmlspecialchars(strip_tags($this->pregunta->getNombre())));
        $this->pregunta->setTipo(htmlspecialchars(strip_tags($this->pregunta->getTipo())));
        $this->pregunta->setOpciones(htmlspecialchars(strip_tags($this->pregunta->getOpciones())));
        $this->pregunta->setId(htmlspecialchars(strip_tags($this->pregunta->getId())));

        // bind data
        $stmt->bindParam(":paso", $this->pregunta->paso);
        $stmt->bindParam(":nombre", $this->pregunta->nombre);
        $stmt->bindParam(":tipo", $this->pregunta->tipo);
        $stmt->bindParam(":opciones", $this->pregunta->opciones);
        $stmt->bindParam(":id", $this->pregunta->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deletePregunta()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->pregunta->setId(htmlspecialchars(strip_tags($this->pregunta->getId())));

        $stmt->bindParam(1, $this->pregunta->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
