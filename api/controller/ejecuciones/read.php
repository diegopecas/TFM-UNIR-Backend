<?php
include_once '../../../config/cors.php';

include_once '../../service/ejecuciones.service.php';

$items = new EjecucionesService();

$stmt = $items->getEjecuciones();
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
            "evaluacion" => $evaluacion,
            "observacion" => $observacion,
            "usuario" => $usuario,
            "fecha" => $fecha
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
