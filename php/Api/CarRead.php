<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: plain/text');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");


include_once '../Database/Connect.php';
include_once '../Class/Voiture.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();
$items = new Voiture($db);
$stmt = $items->getVoiture();
$itemCount = $stmt->rowCount();

echo json_decode($itemCount);
if($itemCount > 0 ) {
    $arr = array();
    $arr["voiture"] = array();
    $arr["itemCount"] = $itemCount;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $e = array(
            "id" => $id,
            "prix" => $prix,
            "kilometrage" => $kilometrage,
            "annee_circulation" => $annee_circulation,
            "caracteristique" => $caracteristique,
            "equipement" => $equipement,
            "image" => $image
        );
        array_push($arr["voiture"], $e);
    }
    echo json_encode($arr);
}

else{
    
    http_response_code(404);
    echo json_encode(
        array("message" => "Pas de voiture trouvé.")
    );
}