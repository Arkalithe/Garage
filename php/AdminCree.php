<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once './Database/Connect.php';

$dbs = new DatabaseConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $email = $_POST["email"];

    if (empty($password) || empty($email)) {
        echo json_encode(["message" => "Veuillez remplir tous les champs."]);
        exit;
    }

    $connexion = $dbs->dbConnectionNamed();
    if (!$connexion) {
        echo json_encode(["message" => "Erreur de connexion à la base de données."]);
        exit;
    }

    $requeteAdmin = "SELECT COUNT(*) as count FROM users WHERE role = 'admin'";
    $statementAdmin = $connexion->prepare($requeteAdmin);
    $statementAdmin->execute();
    $resultAdmin = $statementAdmin->fetch(PDO::FETCH_ASSOC);

    if ($resultAdmin['count'] > 0) {
        echo json_encode(["message" => "Un administrateur existe déjà. Vous ne pouvez pas créer un nouveau compte administrateur."]);
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $requete = "INSERT INTO users (password, email, role) VALUES (:password, :email, 'admin')";
    $statement = $connexion->prepare($requete);
    $statement->bindParam(':password', $passwordHash);
    $statement->bindParam(':email', $email);

    if ($statement->execute()) {
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
    <p>Accédez à <a href="http://localhost:3000">Acceuil Front-end </a> pour vous connecter en localhost:3000.</p>
    <button id="redirectButton">Accéder au front-end Heroku</button>



    <script>
        document.getElementById('redirectButton').addEventListener('click', function() {
            window.location.href = "https://garagevparrotstudi-15b74863d868.herokuapp.com/build/index.html"; 
        });
    </script>
</body>

</html>
g