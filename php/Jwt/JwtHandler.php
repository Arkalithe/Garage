<?php
require '../vendor/autoload.php';


use Firebase\JWT\JWT;

class JwtHandler {
    protected $jwt_secrect;
    protected $token;
    protected $issuedAt;
    protected $expire;
    protected $jwt;

    public function __construct()
    {
        // Default time-zone
        date_default_timezone_set('Europe/France');
        $this->issuedAt = time();
        // Token Validity 
        $this->expire = $this->issuedAt + 3600;
        // Signature
        $this->jwt_secrect = "GarrageVparrot";
    }

    public function jwtEncodeData($iss, $data)
    {

        $this->token = array(
            //Token Identifier
            "iss" => $iss,
            "aud" => $iss,
            // Current timestamp to the token
            "iat" => $this->issuedAt,
            // Token expiration
            "exp" => $this->expire,
            // Payload
            "data" => $data
        );

        $this->jwt = JWT::encode($this->token, $this->jwt_secrect, 'HS256');
        return $this->jwt;
    }

    public function jwtDecodeData($jwt_token)
    {
        try {
            $decode = JWT::decode($jwt_token, $this->jwt_secrect, array('HS256'));
            return [
                "data" => $decode->data
            ];
        } catch (Exception $e) {
            return [
                "message" => $e->getMessage()
            ];
        }
    }
}