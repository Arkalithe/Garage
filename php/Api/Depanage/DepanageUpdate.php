<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,PUT, OPTIONS");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../../Database/Connect.php';
include_once '../../Class/Depanage.php';
include_once '../../AuthCheckRole.php';

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    http_response_code(200);
    exit();
}

$database = new DatabaseConnect();
$db = $database->dbConnection();

$headers = apache_request_headers();
authCheckRole($db, $headers, ['admin']);

$depanages = new Depanage($db);

$id = $_POST['id'];
$title = $_POST['titre'];
$intro = $_POST['intro'];
$message = $_POST['message'];


$imageName = $_FILES['image']['name'];
$imageTmpName = $_FILES['image']['tmp_name'];

$depanages->id = $id;
$depanages->title = $title;
$depanages->intro = $intro;
$depanages->message = $message;
$depanages->image = $imageName;

$destinationFolder = realpath(dirname(__FILE__) . '/../../../src/assests/Image/');
$imagePath = $destinationFolder . '/' . $imageName;

move_uploaded_file($imageTmpName, $imagePath);

if ($depanages->updateDepanage()) {
    echo json_encode(array("message" => "Depanage modification réussie."));
} else {
    http_response_code(500);
    echo json_encode(array("message" => "Problème lors de la modification de la Depanage."));
}
?>