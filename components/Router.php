<?php

class Router {

    private $routes;

    public function __construct() {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include ($routesPath);
    }

    /**
     * Возвращает строку запроса
     * @return string
     */
    private function getURI() {
        //        получить строку запроса
        if (!empty($_SERVER['REQUEST_URI'])){
            $res = trim($_SERVER['REQUEST_URI'], '/');
            if($res == ''){
                $res = 'e';
            }
            return $res;
        }
    }

    public function run() {
//        получить строку запроса
        $uri = $this->getURI();
//        проверить соответствие запросу в routes.php
        foreach ($this->routes as $uriPattern => $path) {
//        Есле есть совпадения, определить контроллер и экшен             
//            if (preg_match("~$uriPattern~", $uri)) {
            if (preg_match("~^$uriPattern~", $uri)) {
//                echo '->>>'.$uriPattern.'||'.$uri;
//                exit();
                $internalRouter = preg_replace("~$uriPattern~", $path, $uri);



                $segments = explode('/', $internalRouter);

                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segments));
                
                $parameters = $segments;

//        Подключить файл Класса-контроллера
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                if(file_exists($controllerFile)) {
                    include_once $controllerFile;
                }
//        Создать обект и вызвать метод(экшен)
 
                    $controllerObject = new $controllerName;
                    
//                    $result = $controllerObject->$actionName();
                    $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                if($result != NULL){
                    break;
                }
            }
        }
    }

}
