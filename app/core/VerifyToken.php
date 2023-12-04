<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class VerifyToken extends User_model{
    public function verifyToken()
    {
        try {
            $token = apache_request_headers()['Authorization'];
            if(!isset($token)) return http_response_code(401);
            $token = $token ? explode(' ', $token)[1] : '';
            $accessTokenDecoded = JWT::decode($token, new Key(ACCESS_TOKEN_SECRET, 'HS256'));
            return $accessTokenDecoded;
        }catch(Exception $e){
            return http_response_code(403);
        }
    }

    public function verifyTokenAndAuthorization(){
        $user = $this->getOneUser($this->verifyToken()->username);
        if($user || $user['isAdmin']) return true;
    }

    public function verifyTokenAndIsAdmin(){
        $user = $this->verifyToken() ? $this->verifyToken() : '';
        if(!isset($user->isAdmin)) return 0;
        return true;
    }
}