<?php
include_once 'Connect.php';


class DatabaseCreate
{
    public function creationDb()
    {
        // Initialisation de la connexion à la base de données
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnection();

        try {

            $sql = "CREATE DATABASE IF NOT EXISTS garagevparrot";
            $conn->exec($sql);
            echo "Création base de donné reussi<br>";
        } catch (PDOException $e) {
            echo $sql . " Création raté ou déja existente<br>" . $e->getMessage();
            exit;
        }

        
    }
   
}

 $conn = null;
 ?>