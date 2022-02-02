<?php
include_once '../../../config/cors.php';

include_once '../../service/preguntas.service.php';
include_once '../../model/pregunta.php';

$item = new PreguntasService();

$data = json_decode(file_get_contents("php://input"));

$item->setIdPregunta($data->id);
$item->setPregunta($data);

$respuesta = new \stdClass();
$respuesta->respuesta = new \stdClass();

if ($item->updatePregunta()) {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "Pregunta actualizado.";
    echo json_encode($respuesta);
} else {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "Pregunta no actualizado.";
    echo json_encode($respuesta);
}
