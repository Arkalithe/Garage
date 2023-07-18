<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");


include_once '../../Database/Connect.php';
include_once '../../Class/Voiture.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();
$items = new Voiture($db);

$items->id = isset($_GET['id']) ? $_GET['id'] : die();

$items->singleVoiture();


if($items->prix != null){
    $arr = array(
        "id" => $items->id,
        "prix" => $items->prix,
        "kilometrage" => $items->kilometrage,
        "annee_circulation" => $items->annee_circulation,
        "caracteristique" => $items->caracteristique,
        "equipement" => $items->equipement,
        "nom" => $items->nom,
        "modele" => $items->modele,
        "prenom" => $items->prenom,
        "numero" => $items->numero,
        "voiture_images" => $items->voiture_images
    );
    http_response_code(200);
    echo json_encode($arr);
} else {
    http_response_code(404);
    echo json_encode("Voiture Introuvable.");
}
