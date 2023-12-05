<?php

class Cart_model extends Database {
    private $table = 'carts';
    protected $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllCart(){
        $this->db->query("SELECT * FROM $this->table");
        return $this->db->fetchAll();
    }

    public function getCartByCodeProduct($codeProduct){
        $this->db->query("SELECT * FROM $this->table WHERE code_product=:code_product");
        $this->db->bind('code_product', $codeProduct);
        return $this->db->single();
    }

    public function getProductByCodeProduct($codeProduct){
        $this->db->query("SELECT * FROM products WHERE code_product=:code_product");
        $this->db->bind('code_product', $codeProduct);
        return $this->db->single();
    }

    public function addToCart($id, $codeProduct, $title, $info, $stock, $img, $price, $sold){
        $this->db->query("INSERT INTO $this->table VALUES (:id, :code_product, :title, :info, :stock, :img, :price, :sold)");
        $this->db->bind('id', $id);
        $this->db->bind('code_product', $codeProduct);
        $this->db->bind('title', $title);
        $this->db->bind('info', $info);
        $this->db->bind('stock', $stock);
        $this->db->bind('img', $img);
        $this->db->bind('price', $price);
        $this->db->bind('sold', $sold);
        $this->db->execute();
    }

    public function deleteCartById($id) {
        $this->db->query("DELETE FROM $this->table WHERE id=:id");
        $this->db->bind('id', $id);
        $this->db->execute();
    }
}