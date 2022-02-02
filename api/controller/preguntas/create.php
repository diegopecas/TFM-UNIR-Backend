<?php
include_once '../../../config/cors.php';

include_once '../../service/preguntas.service.php';

$data = json_decode(file_get_contents("php://input"));

$item = new PreguntasService();

$item->setPregunta($data);
// $item->rol->setNombre($data->nombre);

$respuesta = new \stdClass();
$respuesta->respuesta = new \stdClass();

$id = $item->createPregunta();
if ($id != null) {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "Pregunta creada.";
    $respuesta->respuesta->id = $id;
    echo json_encode($respuesta);
} else {
    $respuesta->respuesta->codigo = 400;
    $respuesta->respuesta->mensaje = "Pregunta no creada.";
    echo json_encode($respuesta);
}
