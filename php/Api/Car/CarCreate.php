<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST,OPTIONS");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../../Database/Connect.php';
include_once '../../Class/Voiture.php';
include_once '../../Class/Image.php';
include_once '../../Class/Equipement.php';
include_once '../../Class/Caracterstique.php';
include_once '../../AuthCheckRole.php';

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    http_response_code(200);
    exit();
}

$database = new DatabaseConnect();
$db = $database->dbConnection();

$headers = apache_request_headers();
authCheckRole($db, $headers, ['admin', "employe"]);

$items = new Voiture($db);

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$modele = $_POST['modele'];
$prix = $_POST['prix'];
$kilometrage = $_POST['kilometrage'];
$annee_circulation = $_POST['annee_circulation'];
$numero = $_POST['numero'];

$equipements = [];

foreach ($_POST as $key => $value) {
    if (strpos($key, 'equipement_') === 0) {
        $equipements[] = $value;
    }
}

$caracteristiques = [];

foreach ($_POST as $key => $value) {
    if (strpos($key, 'caracteristique_') === 0) {
        $caracteristiques[] = $value;
    }
}

$imageNames = [];
$imagePaths = [];

foreach ($_FILES as $key => $file) {
    if (strpos($key, 'image_') === 0) {
        $imageName = $file['name'];
        $destinationFolder = realpath(dirname(__FILE__) . '/../../../src/assests/Image/');
        $imagePath = $destinationFolder . '/' . $imageName;

        if (move_uploaded_file($file['tmp_name'], $imagePath)) {
            $imageNames[] = $imageName;
            $imagePaths[] = $imagePath;
            echo "File uploaded successfully.";
        } else {
            echo "Failed to upload file.";
        }
    }
}

$carData = [
    'nom' => $nom,
    'prenom' => $prenom,
    'modele' => $modele,
    'prix' => $prix,
    'kilometrage' => $kilometrage,
    'annee_circulation' => $annee_circulation,
    'numero' => $numero,
    'image_names' => $imageNames,
    'image_paths' => $imagePaths,
    'equipements' => $equipements
];

$items->prix = $prix;
$items->kilometrage = $kilometrage;
$items->annee_circulation = $annee_circulation;
$items->modele = $modele;
$items->nom = $nom;
$items->prenom = $prenom;
$items->numero = $numero;

if ($items->createVoiture()) {
    $carId = $items->getLastInsertedId();

    if (!empty($equipements)) {
        foreach ($equipements as $equipement) {
            $equipementObj = new Equipement($db);
            $equipementObj->equipement = $equipement;
            $equipementObj->createEquipement($carId);
        }
    }
    if (!empty($caracteristiques)) {
        foreach ($caracteristiques as $caracteristique) {
            $caracteristiqueObj = new Caracteristique($db);
            $caracteristiqueObj->caracteristique = $caracteristique;
            $caracteristiqueObj->createCaracteristique($carId);
        }
    }

    $images = new Image($db);

    foreach ($carData['image_names'] as $index => $imageName) {
        $images->image_url = $imageName;

        if ($images->createImage($carId)) {
            echo "Voiture et image ajout réussi pour l'image: $imageName";
        } else {
            echo "Problème de création de la voiture et de l'image pour l'image: $imageName";
        }
    }
}

echo json_encode($carData);
