<?php

namespace App\Lib\Interfaces;

interface FileInterface
{
    public function toArray(string $path): array;
}
