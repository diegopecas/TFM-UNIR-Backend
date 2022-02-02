<?php
include_once '../../../config/database.php';
include_once '../../model/permiso-rol.php';

class PermisoRolService
{

    // Connection
    private $conn;

    // Table
    private $db_table = "permiso_rol";

    // Columns
    private $permisoRol;

    public function getPermisoRol()
    {
        return $this->permisoRol;
    }

    public function setPermisoRol($permisoRol)
    {
        try {
            $this->permisoRol->permiso = $permisoRol->permiso ??= 0;
            $this->permisoRol->permiso = $permisoRol->rol ??= 0;
        } catch (Exception $ex) {
            return;
        }
    }

    public function setIdPermisoRol($id)
    {
        $this->rol->id = $id;
    }

    public function __construct()
    {
        $database = new Database();
        $this->permisoRol = new PermisoRol();
        $this->conn = $database->getConnection();
    }

    // GET ALL
    public function getPermisoRoles()
    {
        $sqlQuery = "SELECT id, permiso, rol FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createPermisoRol()
    {
        if ($this->rol->permiso) {
            $sqlQuery = "INSERT INTO
                    " . $this->db_table . "
                SET
                    permiso = :permiso
                    rol = :rol
                    ";

            $stmt = $this->conn->prepare($sqlQuery);

            // sanitize
            $this->permisoRol->setPermiso(htmlspecialchars(strip_tags($this->permisoRol->getPermiso())));
            $this->permisoRol->setRol(htmlspecialchars(strip_tags($this->permisoRol->getRol())));

            // bind data
            $stmt->bindParam(":permiso", $this->permisoRol->permiso);
            $stmt->bindParam(":rol", $this->permisoRol->rol);

            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
        }
        return null;
    }

    // SINGLE ROL
    public function getSinglePermisoRol()
    {
        $sqlQuery = "SELECT
                    id, 
                    permiso,
                    rol
                  FROM
                    " . $this->db_table . "
                WHERE 
                   id = ?
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->permisoRol->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->permisoRol->setPermiso($dataRow['id'] ??= 0);
        $this->permisoRol->setPermiso($dataRow['permiso'] ??= 0);
        $this->permisoRol->setRol($dataRow['rol'] ??= 0);
    }

    // UPDATE
    public function updatePermisoRol()
    {
        $sqlQuery = "UPDATE
                    " . $this->db_table . "
                SET
                    permiso = :permiso,
                    rol = :rol
                WHERE 
                    id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->permisoRol->setPermiso(htmlspecialchars(strip_tags($this->permisoRol->getPermiso())));
        $this->permisoRol->setRol(htmlspecialchars(strip_tags($this->permisoRol->getRol())));
        $this->permisoRol->setId(htmlspecialchars(strip_tags($this->permisoRol->getId())));

        // bind data
        $stmt->bindParam(":permiso", $this->permisoRol->permiso);
        $stmt->bindParam(":rol", $this->permisoRol->rol);
        $stmt->bindParam(":id", $this->permisoRol->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deletePermisoRol()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->permisoRol->setId(htmlspecialchars(strip_tags($this->permisoRol->getId())));

        $stmt->bindParam(1, $this->permisoRol->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
