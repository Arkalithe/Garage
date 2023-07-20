<?php
header("Access-Control-Allow-Origin: https://imaginative-lollipop-cdaa75.netlify.app");
header("Access-Control-Allow-Methods: GET,POST,");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once './Database/Connect.php';

$dbs = new DatabaseConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $email = $_POST["email"];

    if (empty($password) || empty($email)) {
        echo "Veuillez remplir tous les champs.";
    } else {
        $connexion = $dbs->dbConnectionNamed();
        if ($connexion) {
            $requeteAdmin = "SELECT COUNT(*) as count FROM users WHERE role = 'admin'";
            $statementAdmin = $connexion->prepare($requeteAdmin);
            $statementAdmin->execute();
            $resultAdmin = $statementAdmin->fetch(PDO::FETCH_ASSOC);
            if ($resultAdmin['count'] > 0) {
                echo "Un administrateur existe déjà. Vous ne pouvez pas créer un nouveau compte administrateur.";
            } else {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $requete = "INSERT INTO users (password, email, role) VALUES (:password, :email, 'admin')";
                $statement = $connexion->prepare($requete);
                $statement->bindParam(':password', $passwordHash);
                $statement->bindParam(':email', $email);
                if ($statement->execute()) {
                    $frontendURL = "https://garagevparrotstudi-15b74863d868.herokuapp.com/";
                    header("Location: $frontendURL");
                } else {
                    echo "Une erreur s'est produite lors de la création de l'administrateur.";
                }
            }
        } else {
            echo "Erreur de connexion à la base de données.";
        }
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
    <p>Accédez à <a href="*">Acceuil Front-end </a> pour vous connecter en localhost:3000.</p>

   
        <button if="redirectButton">Accéder au front-end Heroku</button>
    

    <script>
        document.getElementById('redirectButton').addEventListener('click', function() {
            window.location.href = "https://garagevparrotstudi-15b74863d868.herokuapp.com//build/index.html"; 
        });
    </script>
</body>
</html>
g