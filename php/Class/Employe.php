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

    // Méthode pour obtenir tous les utilisateurs
    public function getUsers()
    {
        try {
            $sql = "SELECT id, email, password, role FROM users";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de l'obtention des utilisateurs");
        }
    }

    // Méthode pour créer un nouvel utilisateur
    public function createUsers()
    {
        try {
            $sql = "INSERT INTO users 
                    SET
                        password = :password,
                        email = :email,
                        role = :role";
            $stmt = $this->conn->prepare($sql);

            // Assainir les entrées
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->role = htmlspecialchars(strip_tags($this->role));

            // Hacher le mot de passe
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

            // Lier les paramètres
            $stmt->bindParam(":password", $hashedPassword);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":role", $this->role);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la création de l'utilisateur");
        }
    }

    // Méthode pour obtenir un seul utilisateur par son ID
    public function singleUsers()
    {
        try {
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
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dataRow) {
                $this->password = $dataRow['password'];
                $this->email = $dataRow['email'];
                $this->role = $dataRow['role'];
            } else {
                throw new Exception("Aucun utilisateur trouvé avec l'ID donné");
            }
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de l'obtention de l'utilisateur");
        }
    }

    // Méthode pour mettre à jour un utilisateur existant
    public function updateUsers()
    {
        try {
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
                throw new Exception('Error: ' . $errorMessage);
            }
            return true;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la mise à jour de l'utilisateur");
        }
    }

    // Méthode pour supprimer un utilisateur existant
    public function deleteUsers()
    {
        try {
            // Vérifier si l'utilisateur est un administrateur
            if ($this->role === 'Admin') {
                return false; 
            }

            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $this->id = htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(":id", $this->id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Échec de la suppression de l'utilisateur");
        }
    }
}
?>
