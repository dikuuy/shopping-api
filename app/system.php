<?php

require '../app/vendor/autoload.php';

function json_status_code($statusCode, $data){
    http_response_code($statusCode);
    if(gettype($data) != 'string'){
        return var_dump(json_encode($data));
    }
    echo json_encode($data);

}

function validateUsername($username){
    if(!$username) return 'Username required!';
    if(strlen($username) < 5) return 'Minimal panjang username 5 karakter';
}

function validateEmail($email){
    if(!$email) return 'Email required!';
    if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email)){
        return 'Email tidak valid!';
    }
    
}

function validatePassword($password){
    if(!$password) return 'Password required!';
    if(strlen($password) < 8) return 'Minimal Panjang password 8 karakter';
}

require_once('models/User_model.php');
require_once('core/App.php');
require_once('core/Constants.php');
require_once('core/Database.php');
require_once('core/VerifyToken.php');
