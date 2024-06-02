<?php
require '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;
use Dotenv\Dotenv;

class JwtHandler
{
    protected $jwt_secret;
    protected $token;
    protected $issuedAt;
    protected $expire;
    protected $jwt;

    public function __construct()
    {
        // Charger les variables d'environnement
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        date_default_timezone_set('Europe/Paris');  // Définit le fuseau horaire par défaut
        $this->issuedAt = time();  // Timestamp actuel
        $this->expire = $this->issuedAt + 3600;  // Expiration dans 1 heure
        $this->jwt_secret = $_ENV['JWT_SECRET'];  // Utilisation de la variable d'environnement pour la clé secrète
    }

    // Méthode pour encoder les données en JWT
    public function jwtEncodeData($iss, $data)
    {
        $this->token = array(
            "iss" => $iss,  // Émetteur
            "aud" => $iss,  // Audience
            "iat" => $this->issuedAt,  // Temps d'émission
            "exp" => $this->expire,  // Temps d'expiration
            "data" => $data  // Données de l'utilisateur
        );

        $this->jwt = JWT::encode($this->token, $this->jwt_secret, 'HS256');
        return $this->jwt;
    }

    // Méthode pour décoder le JWT
    public function jwtDecodeData($jwt_token)
    {
        try {
            // Décodage du token
            $decode = JWT::decode($jwt_token, new Key($this->jwt_secret, 'HS256'));
            $currentTimestamp = time();

            // Si le token est expiré,
            if ($currentTimestamp > $decode->exp) {
                echo "<script>localStorage.removeItem('accessToken');</script>";
                throw new ExpiredException('Le token a expiré');
            }
            return ["data" => $decode->data];
        } catch (ExpiredException $e) {
            return ["message" => $e->getMessage()];
        } catch (Exception $e) {
            return ["message" => $e->getMessage()];
        }
    }
}
