<?php
require '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;

class JwtHandler
{
    protected $jwt_secrect;
    protected $token;
    protected $issuedAt;
    protected $expire;
    protected $jwt;

    public function __construct()
    {
        
        date_default_timezone_set('Europe/Paris');
        $this->issuedAt = time();        
        $this->expire = $this->issuedAt + 3600;       
        $this->jwt_secrect = "clef_secret";
    }

    public function jwtEncodeData($iss, $data)
    {

        $this->token = array(
            
            "iss" => $iss,
            "aud" => $iss,            
            "iat" => $this->issuedAt,            
            "exp" => $this->expire,            
            "data" => $data
        );

        $this->jwt = JWT::encode($this->token, $this->jwt_secrect, 'HS256');
        return $this->jwt;
    }

    public function jwtDecodeData($jwt_token)
    {
        try {
            $decode = JWT::decode($jwt_token, new Key($this->jwt_secrect , 'HS256')); 
            $currentTimestamp = time();
            if ($currentTimestamp > $decode->exp) {
                echo "<script>localStorage.removeItem('accessToken');</script>";
                throw new ExpiredException('Token has expired');
            }
            
            return [
                "data" => $decode->data
            ];
        } catch (ExpiredException $e) {
            return [
                "message" => $e->getMessage()
            ];
        } catch (Exception $e) {
            return [
                "message" => $e->getMessage()
            ];
        }
    }
}
