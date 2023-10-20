<?php

namespace App\Lib;
use App\Lib\Interfaces\FileFactoryInterface;
use App\Lib\Interfaces\FileInterface;

class CsvFactory implements FileFactoryInterface
{
    public function createFile(): FileInterface
    {
        return new Csv();
    }
}