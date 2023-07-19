<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET,POST,");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods,Access-Control-Allow-Origin, Access-Control-Allow-Credentials, Authorization, X-Requested-With");

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';
$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.ethereal.email';
$mail->SMTPAuth = true;
$mail->Username = 'destini.jaskolski50@ethereal.email';
$mail->Password = 'Wq2DcSfQx45GDBmqrR';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$name = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

$modele = isset($_POST['modele']) ? $_POST['modele'] : null;
$prix = isset($_POST['prix']) ? $_POST['prix'] : null;
$nomProprietaire = isset($_POST['nomProprietaire']) ? $_POST['nomProprietaire'] : null;
$prenomProprietaire = isset($_POST['prenomProprietaire']) ? $_POST['prenomProprietaire'] : null;



if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    try {
        var_dump($_POST);

        $mail->setFrom($email, $name);
        $mail->addAddress('larsa_lamont@hotmail.fr');


        $mail->isHTML(true);
        $mail->Subject = 'Contact for Information :';
        $mail->Body = "
            <h3>New Contact Form Submission</h3>
            <p><strong>Nom:</strong> $name</p>
            <p><strong>Prenom:</strong> $prenom</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Message:</strong> $message</p>
        ";
        if ($modele !== null) {
            $mail->Body .= "<p><strong>Modele:</strong> $modele</p>";
        }
        
        if ($prix !== null) {
            $mail->Body .= "<p><strong>Prix:</strong> $prix</p>";
        }
        
        if ($nomProprietaire !== null) {
            $mail->Body .= "<p><strong>Nom Proprietaire:</strong> $nomProprietaire</p>";
        }
        
        if ($prenomProprietaire !== null) {
            $mail->Body .= "<p><strong>Prenom Proprietaire:</strong> $prenomProprietaire</p>";
        }

        $mail->send();
        echo 'Email sent successfully!';
    } catch (Exception $e) {
        echo 'Failed to send email. Please try again later.';
    }
}
