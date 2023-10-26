<?php

namespace App\Lib\Factories;
use App\lib\Interfaces\FileReaderFactoryInterface;
use App\lib\Interfaces\FileReaderInterface;

class XmlReaderFactory implements FileReaderFactoryInterface
{
    public function createFileReader(): FileReaderInterface
    {
        return new XmlReader();
    }
}