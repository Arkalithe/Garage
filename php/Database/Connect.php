<?php

class DatabaseConnect
{
    private $serverName = "i54jns50s3z6gbjt.chr7pe7iynqr.eu-west-1.rds.amazonaws.com";
    private $userName = "ql46xy00vxcox0rc";
    private $password = "xzeto0sv9h22h0er ";
    private $dbname = "clryze4bwb99689n";
    private $port ="3306";
    public $conn;

    public function __construct()
    {
        
    }
    
    public function dbConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->serverName . ";port=" . $this->port, $this->userName, $this->password);
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
