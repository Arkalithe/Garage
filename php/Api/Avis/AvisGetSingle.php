<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: plain/text');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../../Database/Connect.php';
include_once '../../Class/Avis.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();
$items = new Avis($db);
$items->id = isset($_GET['id']) ? $_GET['id'] : die();

$items->singleAvis();

if($items->id != null ){
    $arr = array(
        "id" => $items->id,
        "name" => $items->name,
        "message" => $items->message,
        "note" => $items->note        
    );
    http_response_code(200);
    echo json_encode($arr);
} else {
    http_response_code(404);
    echo json_encode("Avis Introuvable.");
}
