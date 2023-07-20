<?php
include_once './Database/Connect.php';
include_once './Class/Employe.php';

$database = new DatabaseConnect();
$db = $database->dbConnectionNamed();
$employe = new Employee($db);
$stmt = $employe->getUsers();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);


$isAdminExists = false;
foreach ($row as $user) {
    if ($user['role'] === 'admin') {
        $isAdminExists = true;
        break;
    }
}

if ($isAdminExists) {

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

    <script>
        function sendRequest() {
            fetch('./Database/InitDb.php', {
                    method: 'POST',
                    body: new FormData(document.querySelector('form'))
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Request sent successfully');
                        return response.text();
                    } else {
                        throw new Error('Request failed');
                    }
                }).then(data => {
                    console.log(data);
                    alert('Request successful');
                })
                .catch(error => {
                    console.log('An error occurred', error);
                    alert('Request failed');
                });
        }
        function sendRequestbis() {
    fetch("./AdminCree.php", {
      method: "POST",
      body: new FormData(document.querySelector("form")),
    })
      .then(function (response) {
        if (response.ok) {
          console.log("Request sent successfully");
          return response.text();
        } else {
          throw new Error("Request failed");
        }
      })
      .then(function (data) {
        console.log(data);
        alert("Request successful");
        window.location.href = './AdminCree.php'
      })
      .catch(function (error) {
        console.log("An error occurred", error);
        alert("Request failed");
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
            sendRequestbis();
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
        
        <input type="button" value="Envoyer une requête" onclick="sendRequest()">
    </div>
    <div>
<?php

if ($isAdminExists) {

  echo '<div> Un Admin existe déja </div>';
}

?>



    </div>

</body>

</html>