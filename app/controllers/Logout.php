<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Logout extends VerifyToken{
    public function index(){
        if($_SERVER['REQUEST_METHOD'] != 'GET') return json_status_code(401, 'Method Error!');
        if(!$this->verifyTokenAndAuthorization()) return json_status_code(401, 'Access Denied!');

        try {
            if(!isset($_COOKIE['refreshToken'])) return http_response_code(401);
            $token = $_COOKIE['refreshToken'];
    
            $user = JWT::decode($token, new Key(REFRESH_TOKEN_SECRET, 'HS256'));
            $this->updateUser($user->id, '');
            setcookie('refreshToken', '');

            return json_status_code(200, 'Logout Berhasil');
        }catch(Exception $e){
            return json_status_code(500, $e->getMessage());
        }
    }
}