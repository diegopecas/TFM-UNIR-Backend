<?php
include_once '../../../config/database.php';
include_once '../../model/permiso.php';

class PermisosService
{

    // Connection
    private $conn;

    // Table
    private $db_table = "permiso";

    // Columns
    private $permiso; 

    public function getPermiso()
    {
        return $this->permiso;
    }

    public function setPermiso($permiso)
    {
        try {
            $this->permiso->nombre = $permiso->nombre ??= '';
        } catch (Exception $ex) {
            return;
        }
    }

    public function setIdPermiso($id)
    {
        $this->rol->id = $id;
    }

    public function __construct()
    {
        $database = new Database();
        $this->permiso = new Permiso();
        $this->conn = $database->getConnection();
    }

    // GET ALL
    public function getPermisos(){
        $sqlQuery = "SELECT id, nombre FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // SINGLE ROL
    public function getSinglePermiso(){
        $sqlQuery = "SELECT
                    id, 
                    nombre
                  FROM
                    ". $this->db_table ."
                WHERE 
                   id = ?
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->permiso->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->permiso->setNombre($dataRow['id'] ??= 0);
        $this->permiso->setNombre($dataRow['nombre'] ??= '');
    }        
}
