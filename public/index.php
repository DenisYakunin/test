<?php

use App\Core\Router;
use App\Lib\AppException;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $r = new Router;
} catch (AppException $e) {
    $e->logException();
    $e->responseException($e->getCode());
}