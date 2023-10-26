<?php

namespace App\Lib\Interfaces;

interface FileReaderInterface
{
    public function readProductData(string $path): array;
}
