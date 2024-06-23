<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include_once '../Database/Connect.php';
include_once '../Class/Employe.php';
include_once '../Class/JwtHandler.php';

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

$database = new DatabaseConnect();
$db = $database->dbConnection();
$employe = new Employee($db);

function msg($success, $status, $message, $extra = []) {
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ], $extra);
}

$data = json_decode(file_get_contents("php://input"));
$returnData = [];

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $returnData = msg(0, 404, 'Page Not Found');
    echo json_encode($returnData);
    exit();
}

if (!isset($data->email) || !isset($data->password) || empty(trim($data->email)) || empty(trim($data->password))) {
    $fields = ['fields' => ['email', 'password']];
    $returnData = msg(0, 422, 'Please fill all the fields!', $fields);
    echo json_encode($returnData);
    exit();
}

$email = trim($data->email);
$password = trim($data->password);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $returnData = msg(0, 422, 'Invalid Email Address!');
    echo json_encode($returnData);
    exit();
}

if (strlen($password) < 8) {
    $returnData = msg(0, 422, 'Password must be at least 8 characters long!');
    echo json_encode($returnData);
    exit();
}

try {
    $user = $employe->getUserByEmail($email);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $jwt = new JwtHandler();
            $accessToken = $jwt->jwtEncodeData(
                'http://localhost',
                array("id" => $user['id'], "role" => $user['role'])
            );
            error_log('Generated Token: ' . $accessToken); // Debugging line
            $returnData = [
                'success' => 1,
                'message' => 'You have successfully logged in.',
                'accessToken' => $accessToken
            ];
            echo json_encode($returnData); // Ensure proper JSON response
        } else {
            $returnData = msg(0, 422, 'Invalid Password!');
            echo json_encode($returnData);
        }
    } else {
        $returnData = msg(0, 422, 'Invalid Email Address!');
        echo json_encode($returnData);
    }
} catch (PDOException $e) {
    $returnData = msg(0, 500, $e->getMessage());
    echo json_encode($returnData);
}
?>
