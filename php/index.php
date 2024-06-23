<?php
require_once './Database/Connect.php';
require_once './Class/Employe.php';

$database = new DatabaseConnect();
$db = $database->dbConnection();
$employe = new Employee($db);
$stmt = $employe->getUsers();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

$isAdminExists = array_reduce($row, function ($carry, $user) {
    return $carry || $user['role'] === 'admin';
}, false);

if ($isAdminExists) {
    header("Location: ../public/index.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Création d'administrateur</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { text-align: center; }
        form { width: 300px; margin: 0 auto; }
        label { display: block; margin-top: 10px; }
        input[type="password"], input[type="email"] { width: 100%; padding: 5px; margin-top: 5px; }
        input[type="submit"] { width: 100%; padding: 10px; margin-top: 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        input[type="submit"]:hover { background-color: #45a049; }
    </style>
    <script>
        function sendRequest(url) {
            fetch(url, {
                method: 'POST',
                body: new FormData(document.querySelector('form'))
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.redirectUrl) {
                    window.location.href = data.redirectUrl;
                }
            })
            .catch(error => {
                console.error('une erreur est survenue:', error);
                alert('Requete rate');
            });
        }

        function handleSubmit(event) {
            event.preventDefault();
            var formData = new FormData(event.target);
            var password = formData.get("password");
            var email = formData.get("email");
            if (!password || !email) {
                alert("Veuillez remplir tous les champs.");
                return;
            }
            sendRequest('./AdminCree.php');
        }
    </script>
</head>
<body>
    <div>
        <h1>Création d'administrateur</h1>
        <form onsubmit="handleSubmit(event)">
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" required>
            <label for="email">Email :</label>
            <input type="email" name="email" required>
            <input type="submit" value="Créer l'administrateur">
        </form>
    </div>
</body>
</html>
