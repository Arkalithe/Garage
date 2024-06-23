<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

require_once './Database/Connect.php';
require_once './Class/Employe.php';

$database = new DatabaseConnect();
$db = $database->dbConnection();
$employe = new Employee($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $email = $_POST["email"];

    if (empty($password) || empty($email)) {
        echo json_encode(["message" => "Veuillez remplir tous les champs."]);
        exit;
    }

    $stmt = $employe->getUsers();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $isAdminExists = array_reduce($row, function ($carry, $user) {
        return $carry || $user['role'] === 'admin';
    }, false);

    if ($isAdminExists) {
        echo json_encode(["message" => "Un administrateur existe déjà. Vous ne pouvez pas créer un nouveau compte administrateur."]);
        exit;
    }
    $employe->password = $password;
    $employe->email = $email;
    $employe->role = 'admin';

    if ($employe->createUsers()) {
        echo json_encode(["message" => "Administrateur créé avec succès !", "redirectUrl" => "https://garagevparrotstudi-15b74863d868.herokuapp.com/"]);
    } else {
        echo json_encode(["message" => "Une erreur s'est produite lors de la création de l'administrateur."]);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Créé</title>
</head>
<body>
    <h1>Administrateur créé avec succès !</h1>
    <p>L'administrateur a été ajouté à la base de données.</p>
    <p>Vous pouvez maintenant vous connecter au front-end en tant qu'administrateur.</p>
    <p>Accédez à <a href="http://localhost:3000">Accueil Front-end </a> pour vous connecter en localhost:3000.</p>
    <button id="redirectButton">Accéder au front-end Heroku</button>
    <script>
        document.getElementById('redirectButton').addEventListener('click', function() {
            window.location.href = "https://garagevparrotstudi-15b74863d868.herokuapp.com/build/index.html"; 
        });
    </script>
</body>
</html>
