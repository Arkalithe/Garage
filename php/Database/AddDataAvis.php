<?php
include_once 'Connect.php';

class AddDataAvis {
    public function dataAvis(){
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnectionNamed();
        try {
            $avis = [
                ['name' => 'John Marchand', 'message' => 'Content du service', 'note' => '4'],
                ['name' => 'Doe Inconnu', 'message' => 'Prix abordable et personelle agrable',  'note' => '5'],
                ['name' => 'Angry User', 'message' => 'Ils ont prit leurs temps alors que j"etais pressé', 'note' => '2']
            ];

            $stmt = $conn->prepare("INSERT INTO avis (name, message, note)
                VALUES (?, ?, ?)");

            foreach ($avis as $data) {
                $stmt->execute($data);
                echo 'Avis ajouté .<br>';
            }
            echo 'Avis ajouté .<br>';
        }
        catch(PDOException $e) {
            
        }

    }
}