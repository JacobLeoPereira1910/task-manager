<?php

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class Authentication
{
    private $secretKey = 'KEYTECSA';

    public function checkJWT()
    {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            return false;
        }

        $matches = [];
        if (!preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
            return false;
        }
        
        $jwt = $matches[1];

        try {
            $decoded = JWT::decode($jwt, new Key($this->secretKey, 'HS256'));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
