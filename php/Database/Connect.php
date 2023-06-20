<?php

class DatabaseConnect
{
    private $serverName = "localhost";
    private $userName = "root";
    private $password = "";
    private $dbname = "GarageVParrot";

    public function dbConnection()
    {

        try {
            $conn =  new PDO("mysql:host=".$this->serverName.";",$this->userName, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connection base de donné reussi<br>";
            return $conn;
        } catch (PDOException $e) {
            echo "Connection Raté : <br>" . $e->getMessage();
            exit;
        }
    }

    public function dbConnectionNamed()
    {

        try {
            $conn =  new PDO("mysql:host=".$this->serverName.";dbname=".$this->dbname,$this->userName, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connection base de donné reussi<br>";
            return $conn;
        } catch (PDOException $e) {
            echo "Connection Raté : <br>" . $e->getMessage();
            exit;
        }
    }

}
