<?php

header("Access-Control-Allow-Origin: https://imaginative-lollipop-cdaa75.netlify.app");
header("Access-Control-Allow-Methods: GET,POST");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../../Database/Connect.php';
include_once '../../Class/Horaire.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();

$horaire = new Horaire($db);
$data = json_decode(file_get_contents("php://input"));

$horaire->id = $data->id;
$horaire->jour = $data->jour;
$horaire->matin = $data->matin;
$horaire->apresmidi = $data->apresmidi;

if ($horaire->updateHoraire()) {
    echo json_encode("Horaire modifié");
} else {
    echo json_encode("Problème lors de la modification de l'Horaire");}

