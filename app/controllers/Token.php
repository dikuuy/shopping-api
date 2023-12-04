<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Token extends User_model{
    public function index(){
        if($_SERVER['REQUEST_METHOD'] != 'GET') return json_status_code(401, 'Error Method!');
        
        if(!isset($_COOKIE['refreshToken'])) return http_response_code(403);
        $refreshToken = $_COOKIE['refreshToken'];

        $user = $this->getUserByToken($refreshToken);
        if(!isset($user)) return http_response_code(403);

        $refreshTokenDecoded = JWT::decode($user['refreshToken'], new Key(REFRESH_TOKEN_SECRET, 'HS256'));
        if(!isset($refreshTokenDecoded)) return http_response_code(403);

        $accessTokenPayload = [
            'id' => $user['id'],
            'username' => $user['username'],
            'isAdmin' => $user['isAdmin'],
            'iat' => time(),
            'exp' => time() + 15
        ];

        $accessToken = JWT::encode($accessTokenPayload, ACCESS_TOKEN_SECRET, 'HS256');

        return json_status_code(200, $accessToken);
    }
}