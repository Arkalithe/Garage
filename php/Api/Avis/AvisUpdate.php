<?php

header("Access-Control-Allow-Origin: https://ecfgarage.netlify.app");
header("Access-Control-Allow-Methods: GET,POST");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../../Database/Connect.php';
include_once '../../Class/Avis.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();

$items = new Avis($db);
$data = json_decode(file_get_contents("php://input"));

$items->id = $data->id;
$items->name = $data->name;
$items->message = $data->message;
$items->note = $data->note;
$items->moderate = $data->moderate;

if($items->updateAvis()) {
    echo json_encode(["message" => "Avis modifié"]);
} else {
    echo json_encode(["message" => "Problème lors de la modification de l'avis"]);
}