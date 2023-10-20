<?php

class Storage
{
    private array $data;
    private string $path;

    public function __construct(string $path) {

        $this->path = $path;
        $file = file_get_contents($this->path);
        $this->data = json_decode($file, true);

    }

    public function getProducts(): array {
        return $this->data;
    }

    public function saveProducts(array $listProducts): void {
        file_put_contents($this->path, json_encode($listProducts));
    }

}