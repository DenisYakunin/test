<?php

namespace App\lib;
use App\lib\interfaces\FileFactoryInterface;
use App\lib\interfaces\FileInterface;

class XmlFactory implements FileFactoryInterface
{
    public function createFile(): FileInterface
    {
        return new XmlReader();
    }
}