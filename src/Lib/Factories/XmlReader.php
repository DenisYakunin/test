<?php

namespace App\Lib\Factories;
use App\lib\interfaces\FileReaderInterface;

class XmlReader implements FileReaderInterface
{
    public function readProductData($path): array
    {
        $xmlFile = simplexml_load_file($path);
        $productsList = [];

        for ($i = 0; $i <= $xmlFile->product->count() - 1; $i++) {
            $productsParam['code'] = (string) $xmlFile->product[$i]->code;
            $productsParam['price'] = (string) $xmlFile->product[$i]->price;
            $productsParam['name'] = (string)  $xmlFile->product[$i]->name;
            $productsParam['description'] = (string) $xmlFile->product[$i]->description;
            $productsParam['amount_available'] = (integer)  $xmlFile->product[$i]->amount_available;
            $productsParam['status'] = (integer) $xmlFile->product[$i]->status;
            $productsList[] = $productsParam;
        }
        return $productsList;
    }
}