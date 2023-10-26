<?php

namespace App\Core;
use App\Lib\AppException;

class Router
{
    private array $routes;
    private string $url;
    public string $controller;
    public string $action;
    public array $numbers;
    public string $controllerPath;


    public function __construct(array $routes) {
        $this->routes = $routes;
        $this->url = trim($_SERVER['REQUEST_URI'], "/");
    }

    /**
     * @throws AppException
     */
    public function getRequestParams(): void {
        $paramsList = $this->findEndpoint($this->routes, $this->url);
        $params = $this->findParams($paramsList);

        $this->controller = $params['controller'];
        $this->action = $params['action'];
        $this->numbers = $this->extractEndpointNumbers($this->routes, $this->url);
        $this->controllerPath = __DIR__ . '/../Controllers/' . $params['controller'] . '.php';
    }

    /**
     * @throws AppException
     */
    private function findEndpoint(array $routes, string $url): array {
        foreach ($routes as $route => $paramsList) {
            if (preg_match($route, $url)) {
                return $paramsList;
            }
        }
        throw new AppException('Некорректный запрос', 404);
    }

    /**
     * @throws AppException
     */
    private function findParams(array $paramsList): array {
        foreach ($paramsList as $params) {
            if ($params['method'] == $_SERVER['REQUEST_METHOD']) {
                return $params;
            }
        }
        throw new AppException('Некорректный HTTP метод', 404);
    }

    private function extractEndpointNumbers(array $routes, string $url): array {
        foreach ($routes as $route => $paramsList) {
            if (preg_match($route, $url, $matches)) {
                unset($matches[0]);
                return array_values($matches);
            }
        }
        return [];
    }
}