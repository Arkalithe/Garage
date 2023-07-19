<?php

class DatabaseConnect
{
    private $dsn;
    private $username;
    private $password;

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
            if ($databaseUrl) {
                $urlParts = parse_url($databaseUrl);
                $this->dsn = 'mysql:host='.$urlParts['host'].';port='. $urlParts['port'].';dbname='.ltrim($urlParts['path'], '/');
                $this->username = $urlParts['user'];
                $this->password = $urlParts['pass'];
            } else {
                $this->dsn = 'mysql:host=i54jns50s3z6gbjt.chr7pe7iynqr.eu-west-1.rds.amazonaws.com;port=3306;dbname=clryze4bwb99689n';
                $this->username = 'ql46xy00vxcox0rc';
                $this->password = 'vqw7dh2fbvuzcbt0';
            }

            $this->conn = new PDO($this->dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Failed: " . $e->getMessage();
        }

        return $this->conn;
    }

    public function dbConnectionNamed()
    {   
        $this->conn = null;
        try {
            $databaseUrl = getenv('JAWSDB_URL');
            if ($databaseUrl) {
                $urlParts = parse_url($databaseUrl);
                $this->dsn = 'mysql:host=' . $urlParts['host'].';port='.$urlParts['port'].';dbname='.ltrim($urlParts['path'],'/');
                $this->username = $urlParts['user'];
                $this->password = $urlParts['pass'];
            } else {
                $this->dsn = 'mysql:host=i54jns50s3z6gbjt.chr7pe7iynqr.eu-west-1.rds.amazonaws.com;port=3306;dbname=clryze4bwb99689n';
                $this->username = 'ql46xy00vxcox0rc';
                $this->password = 'vqw7dh2fbvuzcbt0';
            }

            $this->conn = new PDO($this->dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Failed: " . $e->getMessage();
        }

        return $this->conn;
    }
}
