<?php
include_once 'Connect.php';


class DatabaseTableCreateUser
{
    public function creationTableUser()
    {
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnectionNamed();

        try {

            $tsql = "CREATE TABLE IF NOT EXISTS USERS (
                    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    email VARCHAR(255) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    role VARCHAR(255) NOT NULL
                    )";           

            $conn->exec($tsql);
            echo 'Table EMPLOYE crée avec succés<br>';
        } catch (PDOException $e) {
            echo $tsql . "Connection Raté : 1234" . $e->getMessage();
            exit;
        }

    }
}
$conn = null;