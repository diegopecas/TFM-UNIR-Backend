<?php
include_once '../../../config/cors.php';

include_once '../../service/opciones-pregunta.service.php';

$items = new OpcionesPreguntaService();

$stmt = $items->getOpcionesPregunta();
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {

    $arr = array();
    $arr["body"] = array();
    $arr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $e = array(
            "id" => $id,
            "pregunta" => $pregunta,
            "nombre" => $nombre
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
