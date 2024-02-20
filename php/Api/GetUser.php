<?php
header("Access-Control-Allow-Origin: https://ecfgarage.netlify.app");
header("Access-Control-Allow-Methods: GET,POST,");
header("Access-Control-Allow-Headers: access");
header('Access-Control-Allow-Credentials: true');
header('Content-Type: plain/text');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once '../Database/Connect.php';
include_once '../AuthMiddleware.php';

$allHeaders = getallheaders();
$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();
$auth = new Auth($db, $allHeaders);

echo json_encode($auth->isValid());
