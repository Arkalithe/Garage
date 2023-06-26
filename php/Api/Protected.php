<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../Database/Connect.php';
require '../vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$db_connection = new DatabaseConnect();
$conn = $db_connection->dbConnectionNamed();

$secret_key = "FIREBASE_KEY";
$jwt = null;

$encodedData = file_get_contents('php://input');  // take data from react native fetch API
$decodedData = json_decode($encodedData, true);

$authHeader = $_SERVER['HTTP_AUTORIZATION'];

$arr = explode("", $authHeader);

$jwt = $arr[1];

if($jwt) {
    try{ 
        $decoded = JWT::decode($jwt, New Key($secret_key, "HS256"));

        echo json_encode(array(
            "message" => "Vous avez acces: ".$jwt,
            "error" => $e->getMessage()
        ));
    }catch (Exception $e){
        http_response_code(401);

        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
}