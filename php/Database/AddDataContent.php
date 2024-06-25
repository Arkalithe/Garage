<?php
include_once 'Connect.php';

class AddDataContent
{
    public function dataContent()
    {
        // Initialisation de la connexion à la base de données
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnection();

        try {
            // Données à insérer dans la table "depannage"
            $depanage = [
                [
                    'title' => 'Depannage',
                    'intro' => 'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum ',
                    'message' =>  'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                   Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                   Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                   Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                   Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                   Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum ',
                    'image' => 'guy.jpg'
                ]
            ];

            $dtmt = $conn->prepare("INSERT INTO depannage (title, intro, message, image)
                VALUES (?, ?, ?, ?)");

            foreach ($depanage as $data) {
                $dtmt->execute([$data['title'], $data['intro'], $data['message'], $data['image']]);
                echo 'Depannage contenu ajouté.<br>';
            }

            // Données à insérer dans la table "reparation"
            $reparations = [
                [
                    'title' => 'Reparation',
                    'intro' => 'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum ',
                    'message' =>   'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                    Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                    Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                    Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                    Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                    Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum ',
                    'image' => 'toolbox.jpg'
                ]
            ];

            $rtmt = $conn->prepare("INSERT INTO reparation (title, intro, message, image)
                VALUES (?, ?, ?, ?)");

            foreach ($reparations as $data) {
                $rtmt->execute([$data['title'], $data['intro'], $data['message'], $data['image']]);
                echo 'Reparartion contenu ajouté.<br>';
            }

            // Données à insérer dans la table "voitureOccasion"
            $occasions = [
                [
                    'title' => 'Occasion',
                    'intro' => 'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
                                Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum ',
                    'image' => 'Voiture.png'
                ]
            ];

            $vtmt = $conn->prepare("INSERT INTO voitureoccasion (title, intro, image)
                VALUES (?, ?, ?)");

            foreach ($occasions as $data) {
                $vtmt->execute([$data['title'], $data['intro'], $data['image']]);
                echo 'Ocasion contenu ajouté.<br>';
            }
        } catch (PDOException $e) {
            echo "Une erreur s'est produite : " . $e->getMessage();
        }
    }
}
?>