<?php

namespace App\Lib;
use PDO;
use Product;

class ProductMapper
{
    private PDO $connection;
    public function __construct($host, $user, $password, $database) {
        $this->connection = new PDO("pgsql:host=$host;dbname=$database;port=5432;", $user, $password);
    }

    public function selectAllProducts(): array
    {
        $statement = $this->connection->prepare('SELECT * FROM products');
        $statement->execute();
        return $statement->fetchAll();
    }

    public function selectProductById(int $id): array
    {
        $statement = $this->connection->prepare('SELECT * FROM products WHERE id = :id');
        $statement->execute(['id' => $id]);
        return $statement->fetchAll();
    }

    public function insertProduct(Product $product): void
    {
        $statement = $this->connection->prepare('INSERT INTO products (code, price, name, description) VALUES (:code, :price, :name, :description)');
        $statement->execute(['code' => $product->code, 'price' => $product->price, 'name' => $product->name, 'description' => $product->description]);
    }

    public function deleteProduct(int $id): void
    {
        $statement = $this->connection->prepare('DELETE FROM products WHERE id = :id');
        $statement->execute(['id' => $id]);
    }

    public function updateProduct(int $id, Product $product): void
    {
        $statement = $this->connection->prepare('UPDATE products SET code = :code, price = :price, name = :name, description = :description WHERE id = :id');
        $statement->execute(['id' => $id, 'code' => $product->code, 'price' => $product->price, 'name' => $product->name, 'description' => $product->description]);
    }

    public function updateProductPrice(int $id, string $price): void
    {
        $statement = $this->connection->prepare('UPDATE products SET price = :price WHERE id = :id');
        $statement->execute(['id' => $id,'price' => $price]);
    }
}