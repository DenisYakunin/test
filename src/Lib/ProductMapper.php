<?php

namespace App\Lib;
use Product;

class ProductMapper
{
    public function mapProductToArray(Product $product): array {
        return [
            'code' => $product->code,
            'price' => $product->price,
            'name' => $product->name,
            'description' => $product->description
        ];
    }

    public function mapRowsToProductsList(array $rowsWithProduct): array {
        $productsList = [];
        foreach ($rowsWithProduct as $row) {
            $product = new Product();
            $product->createProduct($row);
            $productsList[] = $product;
        }
        return $productsList;
    }
}