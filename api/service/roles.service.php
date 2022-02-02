<?php
include_once '../../../config/database.php';
include_once '../../model/rol.php';

class RolesService
{

    // Connection
    private $conn;

    // Table
    private $db_table = "rol";

    // Columns
    private $rol;

    public function getRol()
    {
        return $this->rol;
    }

    public function setRol($rol)
    {
        try {
            $this->rol->nombre = $rol->nombre ??= '';
        } catch (Exception $ex) {
            return;
        }
    }

    public function setIdRol($id)
    {
        $this->rol->id = $id;
    }

    public function __construct()
    {
        $database = new Database();
        $this->rol = new Rol();
        $this->conn = $database->getConnection();
    }

    // GET ALL
    public function getRoles()
    {
        $sqlQuery = "SELECT id, nombre FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createRol()
    {
        if ($this->rol->nombre) {
            $sqlQuery = "INSERT INTO
                    " . $this->db_table . "
                SET
                nombre = :nombre";

            $stmt = $this->conn->prepare($sqlQuery);

            // sanitize
            $this->rol->nombre = htmlspecialchars(strip_tags($this->rol->nombre));

            // bind data
            $stmt->bindParam(":nombre", $this->rol->nombre);


            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
        }
        return null;
    }

    // SINGLE ROL
    public function getSingleRol()
    {
        $sqlQuery = "SELECT
                    id, 
                    nombre
                  FROM
                    " . $this->db_table . "
                WHERE 
                   id = ?
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->rol->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->rol->setId($dataRow['id'] ??= 0);
        $this->rol->setNombre($dataRow['nombre'] ??= '');
    }

    // UPDATE
    public function updateRol()
    {
        if ($this->rol->nombre) {
            $sqlQuery = "UPDATE
                    " . $this->db_table . "
                SET
                    nombre = :nombre
                WHERE 
                    id = :id";

            $stmt = $this->conn->prepare($sqlQuery);

            $this->rol->setNombre(htmlspecialchars(strip_tags($this->rol->getNombre())));
            $this->rol->setId(htmlspecialchars(strip_tags($this->rol->getId())));

            // bind data
            $stmt->bindParam(":nombre", $this->rol->nombre);
            $stmt->bindParam(":id", $this->rol->id);

            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    // DELETE
    function deleteRol()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->rol->setId(htmlspecialchars(strip_tags($this->rol->getId())));

        $stmt->bindParam(1, $this->rol->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
