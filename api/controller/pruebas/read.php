<?php
include_once '../../../config/cors.php';

include_once '../../service/pruebas.service.php';

$items = new PruebasService();

$stmt = $items->getPruebas();
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {

    $arr = array();
    $arr["body"] = array();
    $arr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $e = array(
            "id" => $id,
            "nombre" => $nombre,
            "estado" => $estado,
            "descripcion" => $descripcion
        );

        array_push($arr["body"], $e);
    }
    echo json_encode($arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}
