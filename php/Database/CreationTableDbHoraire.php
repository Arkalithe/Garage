<?php
include_once 'Connect.php';


class DatabaseTableCreateHoraire
{
    public function creationTableHoraire()
    {
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnectionNamed();

        try {

            $tsql = "CREATE TABLE IF NOT EXISTS HORAIRES (
                    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    jour VARCHAR(255) NOT NULL,
                    matin VARCHAR(255) NOT NULL,
                    apresmidi VARCHAR(255) NOT NULL,
                    )";           

            $conn->exec($tsql);
            echo 'Table Horaires crée avec succés<br>';
        } catch (PDOException $e) {
            echo $tsql . "Connection Raté :" . $e->getMessage();
            exit;
        }

    }
}
$conn = null;