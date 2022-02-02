<?php
include_once '../../../config/cors.php';

include_once '../../service/pasos.service.php';

$prueba = isset($_GET['prueba']) ? $_GET['prueba'] : die();

$items = new PasosService();

$stmt = $items->getPasosByPrueba($prueba);
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {

    $arr = array();
    $arr["body"] = array();
    $arr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $e = array(
            "id" => $id,
            "prueba" => $prueba,
            "nombre" => $nombre,
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
