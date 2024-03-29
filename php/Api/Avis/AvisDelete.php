<?php

header("Access-Control-Allow-Origin: https://ecfgarage.netlify.app");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once "../../Database/Connect.php";
include_once "../../Class/Avis.php";

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();
$avis = new Avis($db);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->ids)) {
    $ids = $data->ids;
    $successCount = 0;
    $errorCount = 0;

    foreach ($ids as $id) {
        $avis->id = $id;
        $avis->singleAvis();
        if ($avis->deleteAvis()) {
            $successCount++;
        } else {
            $errorCount++;
        }
    }

    $response = [
        "message" => "Avis supprimés avec succès.",
        "successCount" => $successCount,
        "errorCount" => $errorCount
    ];

    echo json_encode($response);
} else {
    echo json_encode("Pas d'ID Avis donné.");
}
