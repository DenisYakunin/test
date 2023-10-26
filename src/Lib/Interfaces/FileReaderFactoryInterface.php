<?php

namespace App\Lib\Interfaces;

interface FileReaderFactoryInterface
{
    public function createFileReader(): FileReaderInterface;
}