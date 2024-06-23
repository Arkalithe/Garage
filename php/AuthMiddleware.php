<?php
include_once __DIR__ . '/Class/JwtHandler.php';

class AuthMiddleware extends JwtHandler
{
    protected $db;
    protected $headers;
    protected $token;
    protected $exemptedScripts = [
        'CreateAvis.php'
    ];

    public function __construct($db, $headers)
    {
        parent::__construct();
        $this->db = $db;
        $this->headers = $headers;
    }

    public function isValide($requiredRole = null): array
    {
        if ($this->isExemptedScript()) {
            return [
                "success" => 1,
                "data" => null
            ];
        }

        if (array_key_exists('Authorization', $this->headers) && preg_match('/Bearer\s(\S+)/', $this->headers['Authorization'], $matches)) {
            $data = $this->jwtDecodeData($matches[1]);

            if (is_array($data) && isset($data['data']) && is_object($data['data']) && isset($data['data']->id) && isset($data['data']->role)) {
                if ($requiredRole === null || $data['data']->role === $requiredRole) {
                    if ($email = $this->fetchEmail($data['data']->id)) {
                        return [
                            "success" => 1,
                            "data" => (object)[
                                "email" => $email,
                                "role" => $data['data']->role
                            ]
                        ];
                    } else {
                        return [
                            "success" => 0,
                            "message" => "Utilisateur introuvable"
                        ];
                    }
                } else {
                    return [
                        "success" => 0,
                        "message" => "Rôle insuffisant ou données utilisateur invalides"
                    ];
                }
            } else {
                return [
                    "success" => 0,
                    "message" => "Données utilisateur invalides"
                ];
            }
        } else {
            return [
                "success" => 0,
                "message" => "Token non trouvé dans la requête"
            ];
        }
    }

    protected function isExemptedScript(): bool
    {
        $currentScript = basename($_SERVER['SCRIPT_NAME']);
        return in_array($currentScript, $this->exemptedScripts);
    }

    protected function fetchEmail(int $id): ?string
    {
        try {
            $query = "SELECT `email` FROM `users` WHERE `id` = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount()) {
                return $stmt->fetch(PDO::FETCH_ASSOC)['email'];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log('Erreur de récupération de l\'email : ' . $e->getMessage());
            return null;
        }
    }
}
