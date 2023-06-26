<?php

class DatabaseConnect
{
    private $serverName = "localhost";
    private $userName = "root";
    private $password = "";
    private $dbname = "garagevparrot";
    

    public function dbConnection()
    {
 
        try {
            $conn =  new PDO("mysql:host=".$this->serverName.";",$this->userName, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connection base de donné reussi : ";
            return $conn;
        } catch (PDOException $e) {
            echo "Connection Raté : " . $e->getMessage();
            exit;
        }
    }

    public function dbConnectionNamed()
    {   

        try {
            $conn =  new PDO("mysql:host=".$this->serverName.";dbname=".$this->dbname,$this->userName, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connection base de donné reussi : ";
            return $conn;
        } catch (PDOException $e) {
            echo "Connection Raté : " . $e->getMessage();
            exit;
        }
    }

}
