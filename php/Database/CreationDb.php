<?php
include_once 'Connect.php';


class DatabaseCreate
{
    public function creationDb()
    {
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnection();

        try {

            $sql = "CREATE DATABASE IF NOT EXISTS clryze4bwb99689n";
            $conn->exec($sql);
            echo "Création base de donné reussi<br>";
        } catch (PDOException $e) {
            echo $sql . " Création raté ou déja existente<br>" . $e->getMessage();
            exit;
        }

        
    }
   
}

 $conn = null;