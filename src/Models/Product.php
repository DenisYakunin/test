<?php

class Product
{
    public int $id;
    public string $code;
    public string $price;
    public string $name;
    public string $description;
    public string $amount_available;
    public string $status;

    public function createProduct(array $paramList) {
        $paramList = $this->makeSafe($paramList);
        $paramList = $this->changeEncoding($paramList);
        $paramList = $this->changeTypes($paramList);

        if (isset($paramList['id'])) {
            $this->id = $paramList['id'];
        }
        $this->code = $paramList['code'];
        $this->price = $paramList['price'];
        $this->name = $paramList['name'];
        $this->description = $paramList['description'];
        if (isset($paramList['amount_available'])) {
            $this->amount_available = $paramList['amount_available'];
        }
        if (isset($paramList['amount_available'])) {
            $this->status = $paramList['status'];
        }
    }

    private function makeSafe(array $data): array {
        $newData = $data;
        foreach ($newData as &$item) {
            $item = strip_tags($item);
            $item = trim($item);
            $item = addslashes($item);
        }
        return $newData;
    }

    private function changeEncoding(array $arr): array {
        return mb_convert_encoding($arr, 'UTF-8');
    }

    private function changeTypes(array $data): array
    {
        $newData = $data;
        foreach ($newData as $key => $item) {
            if ($key == 'status' or $key == 'amount_available') {
                $newData[$key] = !is_int($item) ? intval($item) : $item;
                continue;
            }
            $newData[$key] = !is_string($item) ? strval($item) : $item;
        }
        return $newData;
    }
}