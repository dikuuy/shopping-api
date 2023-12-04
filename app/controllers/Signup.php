<?php

class Signup extends User_model{
    public function index()
    {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            json_status_code(401, 'Method Error!');
            return 0;
        }

        try {
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $confPassword = htmlspecialchars($_POST['confPassword']);
            
            $users = $this->getAllUSer();
            foreach($users as $user){
                if($username == $user['username']) return json_status_code(401, 'Username '. $username .' sudah ada!');
            }

            if(validateUsername($username)) return json_status_code(401, validateUsername($username));
            if(validateEmail($email)) return json_status_code(401, validateEmail($email));
            if(validatePassword($password)) return json_status_code(401, validatePassword($password));
            if($confPassword != $password) return json_status_code(401, 'Konfirm password tidak sama dengan password!');
    
            $newPassword = password_hash($password, PASSWORD_BCRYPT);
            $this->addUser($username, $email, $newPassword);

            return json_status_code(200, 'Signup Berhasil');
        }catch(Exception $e){
            if($e) return json_status_code(500, $e->getMessage());
        }
    }
}