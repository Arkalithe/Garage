<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,PUT");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../../Database/Connect.php';
include_once '../../Class/Voiture.php';
include_once '../../Class/Image.php';
include_once '../../Class/Equipement.php';
include_once '../../Class/Caracterstique.php';
include_once '../AuthCheckRole.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();

$headers = apache_request_headers();
authCheckRole($conn, $headers, ['admin', "employe"]);

$voiture = new Voiture($db);
$image = new Image($db);
$equipement = new Equipement($db);
$caracteristique = new Caracteristique($db);

$id = $_POST['id'];
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
$voiture->prix = $prix;
$voiture->kilometrage = $kilometrage;
$voiture->annee_circulation = $annee_circulation;
$voiture->modele = $modele;
$voiture->nom = $nom;
$voiture->prenom = $prenom;
$voiture->numero = $numero;

if ($voiture->updateVoiture()) {
    $caracteristique->deleteCaracteristique($id);
    foreach ($caracteristiques as $caracteristiqueName) {
        $caracteristique->caracteristique = $caracteristiqueName;
        $caracteristique->createCaracteristique($id);
    }
    $equipement->deleteEquipement($id);
    foreach ($equipements as $equipementName) {
        $equipement->equipement = $equipementName;
        $equipement->createEquipement($id);
    }
    $image->deleteImage($id);
    foreach ($imagePaths as $imagePath) {
        $image->image_url = $imageName;
        $image->createImage($id);
    }
}
