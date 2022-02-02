<?php
include_once '../../../config/database.php';
include_once '../../model/prueba.php';

class PruebasService
{

    // Connection
    private $conn;

    // Table
    private $db_table = "prueba";

    // Columns
    private $prueba;

    public function getPrueba()
    {
        return $this->prueba;
    }

    public function setPrueba($prueba)
    {
        try {
            $this->prueba->nombre = $prueba->nombre ??= '';
            $this->prueba->estado = $prueba->estado ??= '';
            $this->prueba->descripcion = $prueba->descripcion ??= '';
        } catch (Exception $ex) {
            return;
        }
    }

    public function setIdPrueba($id)
    {
        $this->prueba->id = $id;
    }

    public function __construct()
    {
        $database = new Database();
        $this->prueba = new Prueba();
        $this->conn = $database->getConnection();
    }

    // GET ALL
    public function getPruebas()
    {
        $sqlQuery = "SELECT id, nombre, estado, descripcion FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createPrueba()
    {
        if ($this->prueba->nombre) {
            $sqlQuery = "INSERT INTO
                    " . $this->db_table . "
                SET
                    nombre = :nombre,
                    estado = :estado,
                    descripcion = :descripcion
                    ";

            $stmt = $this->conn->prepare($sqlQuery);

            // sanitize
            $this->prueba->nombre = htmlspecialchars(strip_tags($this->prueba->nombre));
            $this->prueba->estado = htmlspecialchars(strip_tags($this->prueba->estado));
            $this->prueba->descripcion = htmlspecialchars(strip_tags($this->prueba->descripcion));

            // bind data
            $stmt->bindParam(":nombre", $this->prueba->nombre);
            $stmt->bindParam(":estado", $this->prueba->estado);
            $stmt->bindParam(":descripcion", $this->prueba->descripcion);

            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
        }
        return null;
    }

    // SINGLE ROL
    public function getSinglePrueba()
    {
        $sqlQuery = "SELECT
                    id, 
                    nombre,
                    estado,
                    descripcion
                  FROM
                    " . $this->db_table . "
                WHERE 
                   id = ?
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->prueba->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->prueba->setId($dataRow['id'] ??= 0);
        $this->prueba->setNombre($dataRow['nombre'] ??= '');
        $this->prueba->setEstado($dataRow['estado'] ??= '');
        $this->prueba->setDescripcion($dataRow['descripcion'] ??= '');
    }

    // UPDATE
    public function updatePrueba()
    {
        $sqlQuery = "UPDATE
                    " . $this->db_table . "
                SET
                    nombre = :nombre,
                    estado = :estado,
                    descripcion = :descripcion
                WHERE 
                    id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->prueba->setNombre(htmlspecialchars(strip_tags($this->prueba->getNombre())));
        $this->prueba->setEstado(htmlspecialchars(strip_tags($this->prueba->getEstado())));
        $this->prueba->setDescripcion(htmlspecialchars(strip_tags($this->prueba->getDescripcion())));
        $this->prueba->setId(htmlspecialchars(strip_tags($this->prueba->getId())));

        // bind data
        $stmt->bindParam(":nombre", $this->prueba->nombre);
        $stmt->bindParam(":estado", $this->prueba->estado);
        $stmt->bindParam(":descripcion", $this->prueba->descripcion);
        $stmt->bindParam(":id", $this->prueba->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deletePrueba()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->prueba->setId(htmlspecialchars(strip_tags($this->prueba->getId())));

        $stmt->bindParam(1, $this->prueba->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
