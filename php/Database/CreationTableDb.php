<?php
include_once 'Connect.php';


class DatabaseTableCreate
{
    public function creationTable()
    {
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnectionNamed();

        try {

            $tsql = "CREATE TABLE IF NOT EXISTS USERS (
                    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    email VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                    password VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                    )";

            $conn->exec($tsql);
            echo 'Table EMPLOYE crée avec succés<br>';
        } catch (PDOException $e) {
            echo $tsql . "Connection Raté : <br>" . $e->getMessage();
            exit;
        }

    }
}
$conn = null;