<?php

namespace App\Core;
use App\Lib\AppException;

class Model
{
    private const MODEL_PATH = __DIR__ . '/../Models/';
    /**
     * @throws AppException
     */
    public function loadModel($modelName, $arg = null) {

        $modelPath = self::MODEL_PATH . $modelName . '.php';

        if(!file_exists($modelPath)){
            throw new AppException('Модель не существует', 404);
        }

        require_once $modelPath;
        return new $modelName($arg);
    }
}