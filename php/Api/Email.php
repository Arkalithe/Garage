<?php

$name = $_POST['name'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];
$car = $_POST['car'];

$to = 'admin@example.com'; 
$subject = 'Contate pour voiture :' .$car['modele'];
$headers = "De : $name <$email>" . "\r\n";
$body = "Nom : $name\n";
$body .= "Prenom : $prenom\n";
$body .= "Email : $email\n";
$body .= "Telephone : $phone\n";
$body .= "Message : $message\n";
$body .= "Information Voiture : \n";
$body .= "Model: " . $car['modele'] . "\n";
$body .= "Prix: " . $car['prix'] . "\n";
$body .= "Proprietaire voiture : " . $car['nom'] . " " . $car['prenom'];


if (mail($to, $subject, $body, $headers)) {   
    echo 'Email envoyé avec succés !';
} else {    
    echo 'Problème envoie email veuillez essayer plus tards.';
}

?>
