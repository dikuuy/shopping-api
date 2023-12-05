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

    public function addProduct($codeProduct, $title, $info, $stock, $img, $price, $sold){
        $this->db->query("INSERT INTO $this->table VALUES ('', :code_product, :title, :info, :stock, :img, :price, :sold)");
        $this->db->bind('code_product', $codeProduct);
        $this->db->bind('title', $title);
        $this->db->bind('info', $info);
        $this->db->bind('stock', $stock);
        $this->db->bind('img', $img);
        $this->db->bind('price', $price);
        $this->db->bind('sold', $sold);
        $this->db->execute();
    }

    public function updateProductById($id, $title, $info, $stock, $img, $price, $sold){
        $this->db->query("UPDATE products SET title=:title, info=:info, stock=:stock, img=:img, price=:price, sold=:sold WHERE id=:id");
        $this->db->bind('title', $title);
        $this->db->bind('info', $info);
        $this->db->bind('stock', $stock);
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