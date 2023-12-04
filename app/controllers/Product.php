<?php
class Product extends verifyToken {
    private $db;
    public function __construct(){
        require_once('../app/models/Product_model.php');
        $this->db = new Product_model;
    }

    public function index(){
        if($_SERVER['REQUEST_METHOD'] != 'GET') return json_status_code(401, 'Error Method!');
        try {
            $products = $this->db->getAllProducts();
            var_dump($products);
        }catch(Exception $e){
            return json_status_code(500, $e->getMessage());
        }
    }

    public function add(){
        if($_SERVER['REQUEST_METHOD'] != 'POST') return json_status_code(401, 'Error Method!');
        // if(!$this->verifyTokenAndIsAdmin()) return http_response_code(401);

        try {
            $title = htmlspecialchars($_POST['title']);
            $info = htmlspecialchars($_POST['info']);
            $img = htmlspecialchars($_POST['img']);
            $price = htmlspecialchars($_POST['price']);
            $sold = '0';

            $this->db->addProduct($title, $info, $img, $price, $sold);
            return json_status_code(200, 'Tambah data berhasil');
        }catch(Exception $e){
            return json_status_code(500, $e->getMessage());
        }
    }

    public function update($id = ''){
        if($_SERVER['REQUEST_METHOD'] != 'PUT') return json_status_code(401, 'Error Method');
        if(!$this->verifyTokenAndIsAdmin()) return http_response_code(401);
        if(!$id) return http_response_code(401);
        try {
            $user = $this->db->getProductById($id);
            $datas = file_get_contents('php://input');
            $datas = explode('&', $datas);
            $title = '';
            $info = '';
            $img = '';
            $price = '';
            $sold = '';
            foreach($datas as $data){
                $result = explode('=', $data);
                if($result[0] == 'title') $result[1] != '' ? $title = htmlspecialchars($result[1]) : $title = $user['title'];
                if($result[0] == 'info') $result[1] != '' ? $info = htmlspecialchars($result[1]) : $info = $user['info'];
                if($result[0] == 'img') $result[1] != '' ? $img = htmlspecialchars($result[1]) : $img = $user['img'];
                if($result[0] == 'price') $result[1] != '' ? $price = htmlspecialchars($result[1]) : $price = $user['price'];
                if($result[0] == 'sold') $result[1] != '' ? $sold = htmlspecialchars($result[1]) : $sold = $user['sold'];
            }

            $this->db->updateProductById($id, $title, $info, $img, $price, $sold);
            return json_status_code(200, 'Data Berhasil diupdate');
        }catch(Exception $e){
            return json_status_code(500, $e->getMessage());
        }
    }

    public function delete($id = ''){
        if($_SERVER['REQUEST_METHOD'] != 'DELETE') return json_status_code(401, 'Error Method');
        if(!$this->verifyTokenAndIsAdmin()) return http_response_code(401);
        if(!$id) return http_response_code(401);

        try {
            $this->db->deleteProductById($id);
            return json_status_code(200, 'Data berhasil dihapus');
        }catch(Exception $e){
            return json_status_code(500, $e->getMessage());
        }
    }
}