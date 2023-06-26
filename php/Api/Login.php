<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: plain/text');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../Database/Connect.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$db_connection = new DatabaseConnect();
$conn = $db_connection->dbConnectionNamed();

$encodedData = file_get_contents('php://input');  
$decodedData = json_decode($encodedData, true);

$email = $decodedData['email'];
$password = ($decodedData['password']); 

try {
    $SQL = "SELECT * FROM users WHERE email = '$email'";
    $exeSQL = $conn->query($SQL);
    $checkEmail =  $exeSQL->rowCount();

    if ($checkEmail != 0) {
        $arrayu = $exeSQL->fetch();
        if ($arrayu['password'] != $password) {
            $Message = "Mot de passe erroné";
        } else {
            $Message = "Success";
        }
    } else {
        $Message = "Pas de compte";
    }

    $response[] = array("Message" => $Message);
    echo json_encode($response);
} catch (PDOException $e) {
    echo $SQL . "Connexion raté ou déja existente<br>" . $e->getMessage();
    exit;
}
$conn = null;
