<?php
class User extends VerifyToken{
    public function index(){
        if($_SERVER['REQUEST_METHOD'] != 'GET') return json_status_code(401, 'Error Method!');
        if(!$this->verifyTokenAndIsAdmin()) return http_response_code(403);
        
        try {
            $users = $this->getAllUSer();
            if(!isset($users)) return http_response_code(403);
    
            $result = [];
            
            foreach($users as $user) {
                array_push($result, [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'isAdmin' => $user['isAdmin'],
                    'isOnline' => !$user['refreshToken'] ? '0' : '1'
                ]);
            }
            return json_status_code(200, $result);
        }catch(Exception $e){
            return json_status_code(500, $e->getMessage());
        }
    }

    public function detail($id = ''){
        if($_SERVER['REQUEST_METHOD'] != 'GET') return json_status_code(401, 'Error Method!');
        if(!$this->verifyTokenAndIsAdmin()) return http_response_code(403);
        if(!$id) return http_response_code(401);
        try {
            $user = $this->getUserById($id);
            return json_status_code(200, $user);
        }catch(Exception $e){
            return json_status_code(500, $e->getMessage());
        }
    }

    public function update($id = ''){
        if($_SERVER['REQUEST_METHOD'] != 'PUT') return json_status_code(401, 'Error Method!');
        // if(!$this->verifyTokenAndIsAdmin()) return http_response_code(403);
        if(!$id) return http_response_code(401);
        try {
            $user = $this->getUserById($id);
            $datas = file_get_contents('php://input');
            $datas = explode('&', $datas);
            $username = '';
            $email = '';
            $isAdmin = '';
            foreach($datas as $data){
                $result = explode('=', $data);
                if($result[0] == 'username') $result[1] != '' ? $username = htmlspecialchars($result[1]) : $username = $user['username'];
                if($result[0] == 'email') $result[1] != '' ? $email = htmlspecialchars($result[1]) : $email = $user['email'];
                if($result[0] == 'isAdmin') $result[1] != '' ? $isAdmin = htmlspecialchars($result[1]) : $isAdmin = $user['isAdmin'];
            }
    
            if(validateUsername($username)) return json_status_code(401, validateUsername($username));
            if(validateEmail($email)) return json_status_code(401, validateEmail($email));
            if($isAdmin != '1' && $isAdmin != '0') return json_status_code(401, 'Admin harus berisi 1 atau 0!');

            $this->updateUserById($id, $username, $email, $isAdmin);
            return json_status_code(200, 'Data berhasil diupdate');
        }catch(Exception $e){
            return json_status_code(500, $e->getMessage());
        }
    }

    public function delete($id = ''){
        if($_SERVER['REQUEST_METHOD'] != 'DELETE') return json_status_code(401, 'Error Method!');
        if(!$this->verifyTokenAndIsAdmin()) return http_response_code(403);
        if(!$id) return http_response_code(401);
        try {
            $this->deleteUserById($id);
            return json_status_code(200, 'Data berhasil dihapus');
        }catch(Exception $e){
            return json_status_code(500, $e->getMessage());
        }
    }
}