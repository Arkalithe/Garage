<?php

class DatabaseConnect
{
    private $serverName = "localhost";
    private $userName = "root";
    private $password = "";
    private $dbname = "garagevparrot";
    public $conn;
    
    public function dbConnection()
    {
        $this->conn = null;
        try {
            $this->conn =  new PDO("mysql:host=".$this->serverName.";",$this->userName, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
            
        } catch (PDOException $e) {
            echo "Connection Raté : " . $e->getMessage();            
        }
        return $this->conn;
    }

    public function dbConnectionNamed()
    {   
        $this->conn = null;
        try {
            $this->conn =  new PDO("mysql:host=".$this->serverName.";dbname=".$this->dbname,$this->userName, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
        } catch (PDOException $e) {
            echo "Connection Raté : " . $e->getMessage();            
        }
        return $this->conn;
    }

}
