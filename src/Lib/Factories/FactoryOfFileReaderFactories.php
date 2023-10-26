<?php

namespace App\Lib\Factories;
use App\Lib\Interfaces\FileReaderFactoryInterface;

class FactoryOfFileReaderFactories
{
    public function getFileReaderFactory(string $path): FileReaderFactoryInterface {
        $format = substr($path, strpos($path, '.', -5) + 1);
        switch ($format) {
            case 'csv': {
                return new CsvReaderFactory();
            }
            case 'xml': {
                return new XmlReaderFactory();
            }
        }
    }
}