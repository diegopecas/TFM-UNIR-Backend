<?php
include_once '../../../config/database.php';
include_once '../../model/paso.php';

class PasosService
{

    // Connection
    private $conn;

    // Table
    private $db_table = "paso";

    // Columns
    private $paso;

    public function getPaso()
    {
        return $this->paso;
    }

    public function setPaso($paso)
    {
        try {
            $this->paso->prueba = $paso->prueba ??= 0;
            $this->paso->nombre = $paso->nombre ??= '';
            $this->paso->descripcion = $paso->descripcion ??= '';
        } catch (Exception $ex) {
            return;
        }
    }

    public function setIdPaso($id)
    {
        $this->paso->id = $id;
    }

    public function __construct()
    {
        $database = new Database();
        $this->paso = new Paso();
        $this->conn = $database->getConnection();
    }

    // GET ALL
    public function getPasos()
    {
        $sqlQuery = "SELECT id, prueba, nombre, descripcion FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function getPasosByPrueba($prueba)
    {
        $sqlQuery = "SELECT
                        id, 
                        prueba,
                        nombre,
                        descripcion
                    FROM
                        " . $this->db_table . "
                    WHERE 
                    prueba = :prueba";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(":prueba", $prueba);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createPaso()
    {
        if ($this->paso->nombre) {
            $sqlQuery = "INSERT INTO
                    " . $this->db_table . "
                SET
                prueba = :prueba,
                nombre = :nombre,
                descripcion = :descripcion
                ";

            $stmt = $this->conn->prepare($sqlQuery);

            // sanitize
            $this->paso->prueba = htmlspecialchars(strip_tags($this->paso->prueba));
            $this->paso->nombre = htmlspecialchars(strip_tags($this->paso->nombre));
            $this->paso->descripcion = htmlspecialchars(strip_tags($this->paso->descripcion));

            // bind data
            $stmt->bindParam(":prueba", $this->paso->prueba);
            $stmt->bindParam(":nombre", $this->paso->nombre);
            $stmt->bindParam(":descripcion", $this->paso->descripcion);

            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
        }
        return null;
    }

    // SINGLE ROL
    public function getSinglePaso()
    {
        $sqlQuery = "SELECT
                    id, 
                    prueba,
                    nombre,
                    descripcion
                  FROM
                    " . $this->db_table . "
                WHERE 
                   id = ?
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->paso->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->paso->setId($dataRow['id'] ??= 0);
        $this->paso->setPrueba($dataRow['prueba'] ??= 0);
        $this->paso->setNombre($dataRow['nombre'] ??= '');
        $this->paso->setDescripcion($dataRow['descripcion'] ??= '');
    }

    // UPDATE
    public function updatePaso()
    {
        if ($this->paso->nombre) {
            $sqlQuery = "UPDATE
                    " . $this->db_table . "
                SET
                    prueba = :prueba,
                    nombre = :nombre,
                    descripcion = :descripcion
                WHERE 
                    id = :id";

            $stmt = $this->conn->prepare($sqlQuery);

            $this->paso->setPrueba(htmlspecialchars(strip_tags($this->paso->getPrueba())));
            $this->paso->setNombre(htmlspecialchars(strip_tags($this->paso->getNombre())));
            $this->paso->setDescripcion(htmlspecialchars(strip_tags($this->paso->getDescripcion())));
            $this->paso->setId(htmlspecialchars(strip_tags($this->paso->getId())));

            // bind data
            $stmt->bindParam(":prueba", $this->paso->prueba);
            $stmt->bindParam(":nombre", $this->paso->nombre);
            $stmt->bindParam(":descripcion", $this->paso->descripcion);
            $stmt->bindParam(":id", $this->paso->id);

            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    // DELETE
    function deletePaso()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->paso->setId(htmlspecialchars(strip_tags($this->paso->getId())));

        $stmt->bindParam(1, $this->paso->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
