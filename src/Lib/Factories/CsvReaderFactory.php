<?php

namespace App\Lib\Factories;
use App\Lib\Interfaces\FileReaderFactoryInterface;
use App\Lib\Interfaces\FileReaderInterface;

class CsvReaderFactory implements FileReaderFactoryInterface
{
    public function createFileReader(): FileReaderInterface
    {
        return new CsvReader();
    }
}