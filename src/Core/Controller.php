<?php

namespace App\Core;
use App\Lib\AppException;

class Controller
{
    protected $view;

    public function __construct() {
        $this->view = new View();
    }
}