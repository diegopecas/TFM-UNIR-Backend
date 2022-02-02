<?php
include_once '../../../config/database.php';
include_once '../../model/usuario.php';

class UsuarioService
{

    // Connection
    private $conn;

    // Table
    private $db_table = "usuario";

    // Columns
    private $usuario;

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($usuario)
    {
        try {
            $this->usuario->nombre = $usuario->nombre ??= '';
            $this->usuario->contrasena = $usuario->contrasena ??= '';
            $this->usuario->rol = $usuario->rol ??= 0;
        } catch (Exception $ex) {
            return;
        }
    }

    public function setIdUsuario($id)
    {
        $this->usuario->id = $id;
    }

    public function __construct()
    {
        $database = new Database();
        $this->usuario = new Usuario();
        $this->conn = $database->getConnection();
    }

    // GET ALL
    public function getUsuarios()
    {
        $sqlQuery = "SELECT id, nombre, contrasena, rol FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createUsuario()
    {
        if ($this->usuario->nombre) {
            $sqlQuery = "INSERT INTO
                    " . $this->db_table . "
                SET
                    nombre = :nombre,
                    contrasena = :contrasena,
                    rol = :rol
                    ";

            $stmt = $this->conn->prepare($sqlQuery);

            // sanitize
            $this->usuario->nombre = htmlspecialchars(strip_tags($this->usuario->nombre));
            $this->usuario->contrasena = htmlspecialchars(strip_tags($this->usuario->contrasena));
            $this->usuario->rol = htmlspecialchars(strip_tags($this->usuario->rol));

            // bind data
            $stmt->bindParam(":nombre", $this->usuario->nombre);
            $stmt->bindParam(":contrasena", $this->usuario->contrasena);
            $stmt->bindParam(":rol", $this->usuario->rol);
            
            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
        }
        return null;
    }

    // SINGLE ROL
    public function getSingleUsuario()
    {
        $sqlQuery = "SELECT
                    id, 
                    nombre,
                    contrasena,
                    rol
                  FROM
                    " . $this->db_table . "
                WHERE 
                   id = ?
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->usuario->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->usuario->setId($dataRow['id'] ??= 0);
        $this->usuario->setNombre($dataRow['nombre'] ??= '');
        $this->usuario->setContrasena($dataRow['contrasena'] ??= '');
        $this->usuario->setRol($dataRow['rol'] ??= 0);
    }

    public function getUsuarioByPw()
    {
        $sqlQuery = "SELECT
                    id, 
                    nombre,
                    contrasena,
                    rol
                  FROM
                    " . $this->db_table . "
                WHERE 
                   nombre = :nombre 
                AND 
                   contrasena = :contrasena
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->usuario->setNombre(htmlspecialchars(strip_tags($this->usuario->getNombre())));
        $this->usuario->setContrasena(htmlspecialchars(strip_tags($this->usuario->getContrasena())));

        $stmt->bindParam(":nombre", $this->usuario->nombre);
        $stmt->bindParam(":contrasena", $this->usuario->contrasena);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->usuario->setId($dataRow['id'] ??= 0);
        $this->usuario->setNombre($dataRow['nombre'] ??= '');
        $this->usuario->setContrasena($dataRow['contrasena'] ??= '');
        $this->usuario->setRol($dataRow['rol'] ??= 0);

    }

    // UPDATE
    public function updateUsuario()
    {
        $sqlQuery = "UPDATE
                    " . $this->db_table . "
                SET
                    nombre = :nombre,
                    contrasena = :contrasena,
                    rol = :rol
                WHERE 
                    id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->usuario->setNombre(htmlspecialchars(strip_tags($this->usuario->getNombre())));
        $this->usuario->setContrasena(htmlspecialchars(strip_tags($this->usuario->getContrasena())));
        $this->usuario->setRol(htmlspecialchars(strip_tags($this->usuario->getRol())));
        $this->usuario->setId(htmlspecialchars(strip_tags($this->usuario->getId())));

        // bind data
        $stmt->bindParam(":nombre", $this->usuario->nombre);
        $stmt->bindParam(":constrasena", $this->usuario->contrasena);
        $stmt->bindParam(":rol", $this->usuario->rol);
        $stmt->bindParam(":id", $this->usuario->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deleteUsuario()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->usuario->setId(htmlspecialchars(strip_tags($this->usuario->getId())));

        $stmt->bindParam(1, $this->usuario->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
