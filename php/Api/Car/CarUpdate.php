<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: plain/text');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../../Database/Connect.php';
include_once '../../Class/Voiture.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();

$items = new Voiture($db);
$data = json_decode(file_get_contents("php://input"));

$items->id = $data->id;
$items->prix = $data->prix;
$items->kilometrage = $data->kilometrage;
$items->annee_circulation = $data->annee_circulation;
$items->caracteristique = $data->caracteristique;
$items->equipement = $data->equipement;
$items->image = $data->image;

if($items->updateVoiture()) {
    echo json_encode("Voiture modifier");
} else {
    echo json_encode("Problème modification voiture");
}