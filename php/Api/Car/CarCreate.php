<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: text/plain');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../../Database/Connect.php';
include_once '../../Class/Voiture.php';
include_once '../../Class/Image.php'; 
include_once '../../Class/Equipement.php'; 

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();

$items = new Voiture($db);
$images = new Image($db);
$equipements = new Equipement($db);
$data = json_decode(file_get_contents("php://input"));

$items->prix = $data->prix;
$items->kilometrage = $data->kilometrage;
$items->annee_circulation = $data->annee_circulation;
$items->caracteristique = $data->caracteristique;
$items->equipement = $data->equipement;

if ($_SERVER["REQUEST_METHOD"] != "POST") {

} else {
    if ($items->createVoiture()) {
        $voitureId = $db->lastInsertId();

        if (!empty($data->voiture_images)) {
            foreach ($data->voiture_images as $image_url) {
                $images->image_url = $image_url;
                $images->createImage($voitureId);
            }
            if (!empty($data->equipements)) {
                foreach ($data->equipement as $equipement) {
                    $equipements->equipement = $equipement;
                    $equipements->createEquipement($voitureId);
                }


        }


        echo json_encode(array("message" => "Voiture crée avec succes."));
    } else {

        echo json_encode(array("message" => "Creation voiture raté."));
    }
}
}