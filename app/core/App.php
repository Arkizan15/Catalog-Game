<?php

class App{
    protected $controller = 'Auth';
    protected $method = 'index';
    protected $params = []; 
   public function __construct() {
    $url = $this->parseURL();

    if ($url && file_exists('../app/controllers/' . ucfirst($url[0]) . '.php')) {
        $this->controller = ucfirst($url[0]);
        unset($url[0]);

    }
    require_once '../app/controllers/' . $this->controller . '.php';
    $this->controller = new $this->controller;

    if (isset($url[1])) {
        if (method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
    }
}
 if (!empty($url)){
$this->params = array_values($url);
 }
 call_user_func_array([$this->controller, $this->method], $this->params);
}

        
    
    public function parseURL(){
        if(isset($_SERVER['REQUEST_URI'])){
            $url = $_SERVER['REQUEST_URI'];

            // Remove query string if present
            $url = strtok($url, '?');

            // Remove base path if needed (assuming app is in subfolder)
            $basePath = '/catalog-game'; // Adjust if different
            if (strpos($url, $basePath) === 0) {
                $url = substr($url, strlen($basePath));
            }

            $url = rtrim($url, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            // Remove empty first element if present
            if (!empty($url) && $url[0] === '') {
                array_shift($url);
            }

            return $url;
        }
    }

}

