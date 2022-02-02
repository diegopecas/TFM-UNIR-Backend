<?php
include_once '../../../config/cors.php';

include_once '../../service/preguntas.service.php';

$paso = isset($_GET['paso']) ? $_GET['paso'] : die();

$items = new PreguntasService();

// $stmt = $items->getPreguntas();
$stmt = $items->getPreguntasByPaso($paso);
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {

    $arr = array();
    $arr["body"] = array();
    $arr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $e = array(
            "id" => $id,
            "paso" => $paso,
            "nombre" => $nombre,
            "tipo" => $tipo,
            "opciones" => $opciones
        );

        array_push($arr["body"], $e);
    }
    echo json_encode($arr);
} else {
    http_response_code(200);
    echo json_encode(
        array("message" => "No record found.")
    );
}
