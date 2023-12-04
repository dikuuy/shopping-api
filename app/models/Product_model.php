<?php

class Product_model extends Product{
    private $table = 'products';
    private $db;
    public function __construct(){
        $this->db = new Database;
    }

    public function getAllProducts(){
        $this->db->query("SELECT * FROM $this->table");
        return $this->db->fetchAll();
    }

    public function getProductById($id){
        $this->db->query("SELECT * FROM $this->table WHERE id=:id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function addProduct($title, $info, $img, $price, $sold){
        $this->db->query("INSERT INTO $this->table VALUES ('', :title, :info, :img, :price, :sold)");
        $this->db->bind('title', $title);
        $this->db->bind('info', $info);
        $this->db->bind('img', $img);
        $this->db->bind('price', $price);
        $this->db->bind('sold', $sold);
        $this->db->execute();
    }

    public function updateProductById($id, $title, $info, $img, $price, $sold){
        $this->db->query("UPDATE products SET title=:title, info=:info, img=:img, price=:price, sold=:sold WHERE id=:id");
        $this->db->bind('title', $title);
        $this->db->bind('info', $info);
        $this->db->bind('img', $img);
        $this->db->bind('price', $price);
        $this->db->bind('sold', $sold);
        $this->db->bind('id', $id);
        return $this->db->execute();

    }

    public function deleteProductById($id){
        $this->db->query("DELETE FROM $this->table WHERE id=:id");
        $this->db->bind('id', $id);
        $this->db->execute();
    }
}