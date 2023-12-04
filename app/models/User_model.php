<?php

class User_model {
    private $table = 'users';
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function addUser($username, $email, $password, $isAdmin = 0, $refreshToken = ''){
        $this->db->query("INSERT INTO $this->table  VALUES ('',:username, :email, :password, :isAdmin, :refreshToken)");
        $this->db->bind('username', $username);
        $this->db->bind('email', $email);
        $this->db->bind('password', $password);
        $this->db->bind('isAdmin', $isAdmin);
        $this->db->bind('refreshToken', $refreshToken);
        $this->db->execute();
    }

    public function getOneUser($username){
        $this->db->query("SELECT * FROM $this->table WHERE username=:username");
        $this->db->bind('username', $username);
        return $this->db->single();
    }

    public function getAllUSer(){
        $this->db->query('SELECT * FROM '. $this->table);
        return $this->db->fetchAll();
    }

    public function getUserByToken($refreshToken){
        $this->db->query("SELECT * FROM $this->table WHERE refreshToken=:refreshToken");
        $this->db->bind('refreshToken', $refreshToken);
        return $this->db->single();
    }

    public function getUserById($id){
        $this->db->query("SELECT * FROM $this->table WHERE id=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function updateUser($id, $refreshToken){
        $this->db->query("UPDATE $this->table SET refreshToken=:refreshToken WHERE id=:id");
        $this->db->bind('refreshToken', $refreshToken);
        $this->db->bind('id', $id);
        $this->db->execute();
    }

    public function updateUserById($id, $username, $email, $isAdmin){
        $this->db->query("UPDATE $this->table SET username=:username, email=:email, isAdmin=:isAdmin WHERE id=:id");
        $this->db->bind('username', $username);
        $this->db->bind('email', $email);
        $this->db->bind('isAdmin', $isAdmin);
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

    public function deleteUserById($id){
        $this->db->query("DELETE FROM $this->table WHERE id=:id");
        $this->db->bind('id', $id);
        return $this->db->execute();
    }
}