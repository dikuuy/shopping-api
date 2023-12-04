<?php

class App {
    protected $controller = 'Signin';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
      $url = $this->uri();
      if(isset($url[0])) $url[0] = ucfirst($url[0]);

      if(file_exists('../app/controllers/'. $url[0] .'.php')){
        $this->controller = $url[0];
        unset($url[0]);
      }

      require_once('../app/controllers/'. $this->controller .'.php');
      new $this->controller;

      if(isset($url[1])){
        if(method_exists(new $this->controller, $url[1])){
          $this->method = $url[1];
          unset($url[1]);
        }
      }
      
      if(!empty($url)){
        $this->params = array_values($url);
      }


      call_user_func_array([new $this->controller, $this->method], $this->params);
    }

    public function uri()
    {
      if(isset($_GET['data'])){
        $data = rtrim($_GET['data'], '/');
        $data = filter_var($data, FILTER_SANITIZE_URL);
        $data = explode('/', $data);
        return $data;
      }
    }
}