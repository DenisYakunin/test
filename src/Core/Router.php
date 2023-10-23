<?php

namespace App\Core;
use App\Lib\AppException;

class Router
{

    public function __construct(array $routes, \Storage $storageModel, \Product $productModel) {

        $url = trim($_SERVER['REQUEST_URI'], "/");

        $param = $this->findParams($routes, $url);
        $controllerPath = __DIR__ . '/../Controllers/' . $param['controller'] . '.php';

        if(!file_exists($controllerPath)) {
            http_response_code('404');
            throw new AppException('Контроллер не существует', 404);
        }

        require_once $controllerPath;
        $controllerName = $param['controller'];
        $controller = new $controllerName($storageModel, $productModel);

        call_user_func_array([$controller, $param['action']], $param['numbers']);
    }

    private function findParams($routes, $url) {
        foreach ($routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($params as $param) {
                    if ($param['method'] == $_SERVER['REQUEST_METHOD']) {
                        unset($matches[0]);
                        $matches = array_values($matches);
                        $param['numbers'] = $matches;
                        return $param;
                    }
                }
                throw new AppException('Некорректный HTTP метод', 404);
            }
        }
        throw new AppException('Некорректный запрос', 404);
    }

}