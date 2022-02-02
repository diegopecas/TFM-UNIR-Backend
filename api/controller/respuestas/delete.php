<?php
include_once '../../../config/cors.php';

include_once '../../service/respuestas.service.php';

$item = new RespuestasService();

$data = json_decode(file_get_contents("php://input"));

// $item->id = $data->id;
$item->setIdRespuesta($data->id);

$respuesta = new \stdClass();
$respuesta->respuesta = new \stdClass();

if ($item->deleteRespuesta()) {
    $respuesta->respuesta->codigo = 200;
    $respuesta->respuesta->mensaje = "Respuesta eliminado.";
    echo json_encode($respuesta);
} else {
    $respuesta->respuesta->codigo = 400;
    $respuesta->respuesta->mensaje = "Respuesta no pudo ser eliminado.";
    echo json_encode($respuesta);
}
