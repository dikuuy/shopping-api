<?php

class Cart extends VerifyToken {
    private $controller;
    public function __construct(){
        require_once('../app/core/Controller.php');
        $this->controller = new Controller;
    }
    
    public function index(){
        if($_SERVER['REQUEST_METHOD'] != 'GET') return json_status_code(401, 'Error Method!');
        try {
            $carts = $this->controller->model('Cart_model')->getAllCart();
            return json_status_code(200, $carts);
        }catch(Exception $e){
            return json_status_code(500, $e->getMessage());
        }
    }

    public function add(){
        if($_SERVER['REQUEST_METHOD'] != 'POST') return json_status_code(401, 'Error Method!');
        if(!$this->verifyTokenAndAuthorization()) return http_response_code(401);
        try {
            $code_product = htmlspecialchars($_POST['code_product']);
            $product = $this->controller->model('Cart_model')->getProductByCodeProduct($code_product);
            $duplikat = $this->controller->model('Cart_model')->getCartByCodeProduct($code_product);

            if($duplikat){
                return json_status_code(200, 'Tambah data berhasil');
            }

            if(!$product) return http_response_code(404);

            $this->controller->model('Cart_model')->addToCart($product['id'], $product['code_product'], $product['title'], $product['info'], $product['stock'], $product['img'], $product['price'], $product['sold']);
            json_status_code(200, 'Tambah data berhasil');
        }catch(Exception $e) {
            return json_status_code(500, $e->getMessage());
        }
    }

    public function delete($id = ''){
        if($_SERVER['REQUEST_METHOD'] != 'DELETE') return json_status_code(401, 'Error Method!');
        // if(!$this->verifyTokenAndAuthorization()) return http_response_code(401);
        if(!$id) return http_response_code(401);
        try {
            $this->controller->model('Cart_model')->deleteCartById($id);
            return json_status_code(200, 'Data Berhasil dihapus');
        }catch(Exception $e){
            return json_status_code(500, $e->getMessage());
        }
    }
}