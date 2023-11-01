<?php

namespace App\Lib;
use PDO;
use Product;

class ProductRepository
{
    private PDO $connection;
    private ProductMapper $mapper;

    public function __construct(PDO $connection, ProductMapper $productMapper) {
        $this->connection = $connection;
        $this->mapper = $productMapper;
    }

    public function selectAllProducts(): array
    {
        $statement = $this->connection->prepare('SELECT * FROM products');
        $statement->execute();
        return $this->mapper->mapRowsToProductsList($statement->fetchAll());
    }

    public function selectProductById(int $id): array
    {
        $statement = $this->connection->prepare('SELECT * FROM products WHERE id = :id');
        $statement->execute(['id' => $id]);
        return $this->mapper->mapRowsToProductsList($statement->fetchAll());
    }

    public function insertProduct(Product $product): void
    {
        $statement = $this->connection->prepare('INSERT INTO products (code, price, name, description) VALUES (:code, :price, :name, :description)');
        $statement->execute($this->mapper->mapProductToArray($product));
    }

    public function deleteProduct(int $id): void
    {
        $statement = $this->connection->prepare('DELETE FROM products WHERE id = :id');
        $statement->execute(['id' => $id]);
    }

    public function updateProduct(int $id, Product $product): void
    {
        $statement = $this->connection->prepare('UPDATE products SET code = :code, price = :price, name = :name, description = :description WHERE id = :id');
        $params = $this->mapper->mapProductToArray($product);
        $params['id'] = $id;
        $statement->execute($params);
    }

    public function updateProductPrice(int $id, string $price): void
    {
        $statement = $this->connection->prepare('UPDATE products SET price = :price WHERE id = :id');
        $statement->execute(['id' => $id,'price' => $price]);
    }
}