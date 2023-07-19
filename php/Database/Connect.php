<?php

class DatabaseConnect
{
    private $dsn = 'mysql:host=i54jns50s3z6gbjt.chr7pe7iynqr.eu-west-1.rds.amazonaws.com;port=3306;dbname=clryze4bwb99689n';
    private $username = 'ql46xy00vxcox0rc';
    private $password = 'vqw7dh2fbvuzcbt0';

    public $conn;

    public function __construct()
    {
        $this->dbConnection();
    }
    
    public function dbConnection()
    {
        $this->conn = null;
        try {      
            $databaseUrl = getenv('JAWSDB_URL');
            $urlParts = parse_url($databaseUrl);
            $this->dsn = 'mysql:host=' . $urlParts['host'] . ';port=' . $urlParts['port'] . ';dbname=' . ltrim($urlParts['path'], '/');
            $this->username = $urlParts['user'];
            $this->password = $urlParts['pass'];
            $this->conn = new PDO($this->dsn, $this->username, $this->password);
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
            $this->conn =  new PDO($this->dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
          
        } catch (PDOException $e) {
            echo "Connection Raté : " . $e->getMessage();            
        }
        return $this->conn;
    }

}
