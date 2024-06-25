<?php
include_once 'Connect.php';

class AddDataAvis {
    public function dataAvis(){
        // Initialisation de la connexion à la base de données
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnection();
        
        try {
            // Données des avis à insérer dans la table avis
            $avis = [
                ['name' => 'John Marchand', 'message' => 'Content du service', 'note' => '4', 'moderate' => '1'],
                ['name' => 'Doe Inconnu', 'message' => 'Prix abordable et personelle agrable',  'note' => '5', 'moderate' => '1'],
                ['name' => 'Angry User', 'message' => 'Ils ont prit leurs temps alors que j"etais pressé', 'note' => '2', 'moderate' => '0']
            ];

            $stmt = $conn->prepare("INSERT INTO avis (name, message, note, moderate)
                VALUES (?, ?, ?, ?)");

            foreach ($avis as $data) {
                $stmt->execute([$data["name"], $data["message"], $data["note"], $data["moderate"]]);
                echo 'Avis ajouté .<br>';
            }
            echo 'Avis ajouté .<br>';
        }
        catch(PDOException $e) {
            
        }

    }
}
?>