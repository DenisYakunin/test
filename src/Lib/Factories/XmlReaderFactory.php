<?php

namespace App\Lib\Factories\FileReaderFactory;
use App\lib\Interfaces\FileReaderFactoryInterface;
use App\lib\Interfaces\FileReaderInterface;

class XmlReaderFactory implements FileReaderFactoryInterface
{
    public function createFileReader(): FileReaderInterface
    {
        return new XmlReader();
    }
}