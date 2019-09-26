<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate product object
include_once '../objects/tareas.php';

$database = new Database();
$db = $database->getConnection();

$tarea = new Tarea($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if  (
    !empty($data->tarea) &&
    !empty($data->lugar_Tarea) &&
    !empty($data->hora_Tarea) &&
    !empty($data->fecha_Tarea) 
    )
{

    // set product property values
    $tarea->tarea = $data->tarea;
    $tarea->lugar_Tarea = $data->lugar_Tarea;
    $tarea->hora_Tarea = $data->hora_Tarea;
    $tarea->fecha_Tarea = $data->fecha_Tarea;
    

    // create the product
    if($tarea->create())
    {
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "event was created."));
    }
    // if unable to create the product, tell the user
    else
    {
        // set response code - 503 service unavailable
        http_response_code(503);
        // tell the user
        echo json_encode(array("message" => "Unable to create event."));
    }
}

// tell the user data is incomplete
    else
    {
    // set response code - 400 bad request
    http_response_code(400);
    // tell the user
    echo json_encode(array("message" => "Unable to create quote. Data is incomplete."));
    }
?>