<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,PUT");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../../Database/Connect.php';
include_once '../../Class/Reparation.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();

$reparations = new Reparation($db);

$id = $_POST['id'];
$title = $_POST['titre'];
$intro = $_POST['intro'];
$message = $_POST['message'];


$imageName = $_FILES['image']['name'];
$imageTmpName = $_FILES['image']['tmp_name'];

$reparations->id = $id;
$reparations->title = $title;
$reparations->intro = $intro;
$reparations->message = $message;
$reparations->image = $imageName;

$destinationFolder = realpath(dirname(__FILE__) . '/../../../src/assests/Image/');
$imagePath = $destinationFolder . '/' . $imageName;

move_uploaded_file($imageTmpName, $imagePath);

if ($reparations->updateReparation()) {
    echo json_encode(array("message" => "Reparation modification réussie."));
} else {
    http_response_code(500);
    echo json_encode(array("message" => "Problème lors de la modification de la Reparatio."));
}
?>