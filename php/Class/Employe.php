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
        $sql = "SELECT id, email, password FROM users";
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
            SET ";

    $params = array();

    if (!empty($this->email)) {
        $sql .= "email = :email, ";
        $params[':email'] = $this->email;
    }

    if (!empty($this->password)) {
        $sql .= "password = :password, ";
        $params[':password'] = password_hash($this->password, PASSWORD_DEFAULT);
    }

    if (!empty($this->role)) {
        $sql .= "role = :role, ";
        $params[':role'] = $this->role;
    }
    $sql = rtrim($sql, ', ');

    $sql .= " WHERE id = :id";
    $params[':id'] = $this->id;

    $stmt = $this->conn->prepare($sql);

    foreach ($params as $param => $value) {
        $stmt->bindValue($param, $value);
    }

    if (!$stmt->execute()) {
        $errorInfo = $stmt->errorInfo();
        $errorMessage = isset($errorInfo[2]) ? $errorInfo[2] : 'Unknown error';
        echo json_encode('Error: ' . $errorMessage);
        return false;
    }
    return true;
}

    function deteleteUsers()
    {
        if ($this->role === 'Admin') {
            return false; 
        }
        
        $sql = "DELETE FROM users WHERE id= :id";
        $stmt = $this->conn->prepare($sql);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
