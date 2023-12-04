<?php

class Database {
    private $dbHost = DBHOST;
    private $dbUsername = DBUSERNAME;
    private $dbPassword = DBPASSWORD;
    private $dbName = DBNAME;
    protected $db;
    protected $stmt;

    public function __construct()
    {
        try {
            $option = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
            $conn = new PDO("mysql:host=". $this->dbHost .";dbname=". $this->dbName, $this->dbUsername, $this->dbPassword, $option);
            $this->db = $conn;
        }catch(PDOException $e){
            die('Failed to connect with MySQL: '. $e->getMessage());
        }
    }
    public function query($query){
        $this->stmt = $this->db->prepare($query);
    }
    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute(){
        $this->stmt->execute();
    }

    public function fetchAll(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
}