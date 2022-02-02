<?php
include_once '../../../config/cors.php';

include_once '../../service/preguntas.service.php';

$item = new PreguntasService();

$data = json_decode(file_get_contents("php://input"));

// $item->id = $data->id;
$item->setIdPregunta($data->id);

$respuesta = new \stdClass();
$respuesta->respuesta = new \stdClass();

if ($item->deletePregunta()) {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "Pregunta eliminado.";
    echo json_encode($respuesta);
} else {
    $respuesta->respuesta->codigo = 400;
    $respuesta->respuesta->mensaje = "Pregunta no pudo ser eliminado.";
    echo json_encode($respuesta);
}
