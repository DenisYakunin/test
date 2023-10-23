<?php

namespace App\Lib;
use App\Lib\Interfaces\FileFactoryInterface;
use App\Lib\CsvReader;
use App\Lib\XmlReader;

class FactoryOfFileFactories
{
    public function getFileFactory(string $path): FileFactoryInterface {
        $format = substr($path, strpos($path, '.', -5) + 1);
        switch ($format) {
            case 'csv': {
                return new CsvFactory();
            }
            case 'xml': {
                return new XmlFactory();
            }
        }
    }
}