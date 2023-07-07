<?php

class Employee
{

    private $conn;
    public $id;
    public $email;
    public $password;
    public $role;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getUsers()
    {
        $sql = "SELECT id, email, password, FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }


    public function createUsers()
    {
        $sql = "INSERT INTO users 
                SET
                    password = :password,
                    email = :email,
                    role = :role";
        $stmt = $this->conn->prepare($sql);

        $this->password = htmlspecialchars(strip_tags(($this->password)));
        $this->email = htmlspecialchars(strip_tags(($this->email)));
        $this->role = htmlspecialchars(strip_tags(($this->role)));

        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":role", $this->role);


        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function singleUsers()
    {
        $sql = "SELECT 
                    id, 
                    password, 
                    email,
                    role
                FROM 
                    users 
                WHERE 
                    id = ? 
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch();

        $this->password = $dataRow['password'];
        $this->email = $dataRow['email'];
        $this->role = $dataRow['role'];
    }

    public function updateUsers()
    {
        $sql = "UPDATE users 
                SET 
                    password = :password,
                    email = :email,
                    role = :role
                WHERE
                    id= :id";

        $stmt = $this->conn->prepare($sql);

        $this->password = htmlspecialchars(strip_tags(($this->password)));
        $this->email = htmlspecialchars(strip_tags(($this->email)));
        $this->id = htmlspecialchars(strip_tags(($this->id)));
        $this->role = htmlspecialchars(strip_tags(($this->role)));

        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam("id", $this->id);
        $stmt->bindParam(":role", $this->role);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    function deteleteUsers()
    {
        $sql = "DELETE FROM users WHERE id= :id";

        $stmt = $this->conn->prepare($sql);
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
