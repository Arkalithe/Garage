<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../../Database/Connect.php';
include_once '../../Class/Horaire.php';
include_once '../AuthCheckRole.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();

$headers = apache_request_headers();
authCheckRole($conn, $headers, ['admin']);

$horaire = new Horaire($db);
$data = json_decode(file_get_contents("php://input"));

$horaire->id = $data->id;
$horaire->day_id = $data->day_id;
$horaire->heure_start = $data->heure_start;
$horaire->heure_fin = $data->heure_fin;
$horaire->time_period = $data->time_period;
$horaire->is_fermed = $data->is_fermed;

if ($horaire->updateHoraire()) {
    echo json_encode("Horaire modifié");
} else {
    echo json_encode("Problème lors de la modification de l'Horaire");}

