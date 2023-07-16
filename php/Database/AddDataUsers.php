<?php
include_once 'Connect.php';

class placeholderName {
    public function placeholderName(){
        $db_connection = new DatabaseConnect();
        $conn = $db_connection->dbConnectionNamed();
        try {

        }
        catch(PDOException $e) {
            
        }

    }
}