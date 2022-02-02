<?php
    include_once '../../../config/cors.php';
    include_once '../../service/pasos.service.php';
    include_once '../../model/paso.php';

    $item = new PasosService();

    $data = new Paso();

    $data->id = isset($_GET['id']) ? $_GET['id'] : die();

    $item->setIdPaso($data->id);

    $item->getSinglePaso();

    if($item->getPaso()->id != null){
        // create array
        $emp_arr = array(
            "id" =>  $item->getPaso()->id,
            "prueba" => $item->getPaso()->prueba,
            "nombre" => $item->getPaso()->nombre,
            "descripcion" => $item->getPaso()->descripcion
        );
      
        http_response_code(200);
        echo json_encode(array("body" => $emp_arr));
    } else{
        http_response_code(404);
        echo json_encode("Employee not found.");
    }
?>