<?php
include_once '../../../config/cors.php';

include_once '../../service/preguntas.service.php';
include_once '../../model/pregunta.php';

$item = new PreguntasService();

$data = new Pregunta();

$data->id = isset($_GET['id']) ? $_GET['id'] : die();

$item->setIdPregunta($data->id);

$item->getSinglePregunta();

if ($item->getPregunta()->id != null) {
    // create array
    $emp_arr = array(
        "id" =>  $item->getPregunta()->id,
        "paso" => $item->getPregunta()->paso,
        "nombre" => $item->getPregunta()->nombre,
        "tipo" => $item->getPregunta()->tipo,
        "opciones" => $item->getPregunta()->opciones
    );
    // $emp_arr = array($item->getPregunta());

    http_response_code(200);
    echo json_encode(array("body" => $emp_arr));
} else {
    http_response_code(404);
    echo json_encode("Employee not found.");
}
