<?php

namespace App\Lib\Interfaces;

interface FileFactoryInterface
{
    public function createFile(): FileInterface;
}
