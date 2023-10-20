<?php

namespace App\Core;
use App\Lib\AppException;

class View
{
    public function render($view, $data = []): void {
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        if (!file_exists($viewPath)) {
            throw new AppException('Представление не существует', 404);
        }
        extract($data);
        require_once $viewPath;
    }
}