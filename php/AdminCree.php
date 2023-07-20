<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

include_once './Database/Connect.php';

$dbs = new DatabaseConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $motDePasse = $_POST["mot_de_passe"];
    $email = $_POST["email"];

    if (empty($motDePasse) || empty($email)) {
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
                $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);
                $requete = "INSERT INTO users (mot_de_passe, email, role) VALUES (:motDePasse, :email, 'admin')";
                $statement = $connexion->prepare($requete);
                $statement->bindParam(':motDePasse', $motDePasseHash);
                $statement->bindParam(':email', $email);
                if ($statement->execute()) {
                    header("Location: AdminCree.php");
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
    <p>Accédez à <a href="http://localhost:3000">Acceuil Front-end </a> pour vous connecter.</p>

    <form action="http://your-heroku-react-app-url" method="GET">
        <button type="submit">Accéder au front-end Heroku</button>
    </form>
</body>
</html>
