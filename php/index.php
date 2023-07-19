<?php
require_once './Database/Connect.php';

try {
    require_once './Database/InitDb.php';
$init = new InitDb();
$dbInit = $init->initDb();
} catch(PDOException $e) {
echo "Erreure : " . $e;
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $motDePasse = $_POST["mot_de_passe"];
    $email = $_POST["email"];

    if (empty($motDePasse) || empty($email)) {
        echo "Veuillez remplir tous les champs.";
    } else {
        $db = new DatabaseConnect();
        $connexion = $db->dbConnectionNamed();        
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
                    exit;
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
    <title>Création d'administrateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        form {
            width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div>
    <h1>Création d'administrateur</h1>
    
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" name="mot_de_passe" required>

        <label for="email">Email :</label>
        <input type="email" name="email" required>

        <input type="submit" value="Créer l'administrateur"></div>
    </form>
</body>
</html>
