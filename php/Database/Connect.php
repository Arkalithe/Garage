<?php

class DatabaseConnect
{
    // Détails privé de la connexion à la base de données
    private $serverName = "localhost";
    private $dbname = "garagevparrot";
    private $password = "";
    private $userName = "root";
    public $conn;

    // Initialisaton a la connexion de la base de données
    public function __construct()
    {
        $this->dbConnection();
    }
    
    // Connexion à la base de données sans spécifier de nom de base de données
    public function dbConnection()
    {
        $this->conn = null;
        try {     

            $this->conn = new PDO(
                "mysql:host=".$this->serverName.";",$this->userName, $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Failed: " . $e->getMessage();
        }

        return $this->conn;
    }

    // Connexion à la base de données en spécifiant un nom de base de données
    public function dbConnectionNamed()
    {   
        $this->conn = null;
        try {
            $this->conn =  new PDO("mysql:host=".$this->serverName.";dbname=".$this->dbname,$this->userName, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Failed: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>