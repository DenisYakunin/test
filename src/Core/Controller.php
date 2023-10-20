<?php

namespace App\Core;
use App\Lib\AppException;

class Controller
{
    protected $view;

    public function __construct() {
        $this->view = new View();
    }

    public function loadModel($modelName, $arg = null) {

        $modelPath = __DIR__ . '/../Models/' . $modelName . '.php';

        if(!file_exists($modelPath)){
            throw new AppException('Модель не существует', 404);
        }

        require_once $modelPath;
        return new $modelName($arg);
    }
}