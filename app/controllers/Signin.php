<?php
use Firebase\JWT\JWT;

class Signin extends User_model{
    public function index()
    {
        if($_SERVER['REQUEST_METHOD'] != 'POST') {
            json_status_code(401, 'Method Error!');
            return 0;
        }
        
        try {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);

            if(validateUsername($username)) return json_status_code(401, validateUsername($username));
            if(validatePassword($password)) return json_status_code(401, validatePassword($password));
            $user = $this->getOneUser($username);

            if(!password_verify($password, $user['password'])) return json_status_code(401, 'Username atau password salah!');
            $isuuedAt = time();
            $accessTokenPayload = [
                'id' => $user['id'],
                'username' => $user['username'],
                'isAdmin' => $user['isAdmin'],
                'iat' => $isuuedAt,
                'exp' => time() + 20
            ];

            $refreshTokenPayload = [
                'id' => $user['id'],
                'username' => $user['username'],
                'isAdmin' => $user['isAdmin'],
                'iat' => $isuuedAt,
                'exp' => time() + 60 * 60 * 24 * 30
            ];

            // var_dump(__DIR__);
            // return 0;

            $accessToken = JWT::encode($accessTokenPayload, ACCESS_TOKEN_SECRET, 'HS256');
            $refreshToken = JWT::encode($refreshTokenPayload, REFRESH_TOKEN_SECRET, 'HS256');
            $this->updateUser($user['id'], $refreshToken);
            
            setcookie('refreshToken', $refreshToken, time() + 60 * 60 * 24);

            json_status_code(200, $accessToken);
        }catch(Exception $e){
            json_status_code(500, $e->getMessage());
        }
    }
}