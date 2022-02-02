<?php
include_once '../../../config/cors.php';

include_once '../../service/opciones-pregunta.service.php';

$item = new OpcionesPreguntaService();

$data = json_decode(file_get_contents("php://input"));

// $item->id = $data->id;
$item->setIdOpcionPregunta($data->id);

$respuesta = new \stdClass();
$respuesta->respuesta = new \stdClass();

if ($item->deleteOpcionPregunta()) {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "OpcionPregunta eliminado.";
    echo json_encode($respuesta);
} else {
    $respuesta->respuesta->codigo = 400;
    $respuesta->respuesta->mensaje = "OpcionPregunta no pudo ser eliminado.";
    echo json_encode($respuesta);
}
