<?php

namespace App\Lib;
use App\Lib\Interfaces\FileInterface;

class CsvReader implements FileInterface
{
    public function toArray(string $path): array {
        $csvFile = file($path);
        $productsList = [];
        foreach ($csvFile as $row) {
            $parsedRow = str_getcsv($row, ';');
            $productsParam['code'] = $parsedRow[0];
            $productsParam['price'] = str_replace(',', '.', $parsedRow[1]);
            $productsParam['name'] = $parsedRow[2];
            $productsParam['description'] = $parsedRow[3];
            $productsParam['amount_available'] = $parsedRow[4];
            $productsParam['status'] = $parsedRow[5];
            $productsList[] = $productsParam;
        }
        return $productsList;
    }
}