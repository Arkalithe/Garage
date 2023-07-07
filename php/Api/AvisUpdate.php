<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: plain/text');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");


include_once '../Database/Connect.php';
include_once '../Class/Avis.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();

$items = new Avis($db);
$data = json_decode(file_get_contents("php://input"));

$items->id = $data->id;
$items->name = $data->name;
$items->message = $data->message;
$items->note = $data->note;

if($items->updateAvis()) {
    echo json_encode("Avis modifier");
} else {
    echo json_encode("Problème modification Avis");
}