<?php

use App\Lib\AppException;

class Product
{
    private const NAME_MAX_SIZE = 64;
    private const NAME_MIN_SIZE = 5;
    private const DESCRIPTION_MAX_SIZE = 300;

    public string $code;
    public string $price;
    public string $name;
    public string $description;
    public string $amount_available;
    public string $status;

    public function __construct(array $paramList, int $row = 0) {

        $paramList = $this->makeSafe($paramList);
        $paramList = $this->changeEncoding($paramList);
        $paramList = $this->changeTypes($paramList);

        $this->code = $paramList['code'];
        $this->price = $paramList['price'];
        $this->name = $paramList['name'];
        $this->description = $paramList['description'];
        $this->amount_available = $paramList['amount_available'];
        $this->status = $paramList['status'];
    }

    private function isValidCode(string $code): bool {
        $pattern = preg_match('/^\d{0,3}-\d+$/',$code);
        if ((strlen($code) > 10) or !$pattern) {
            throw new AppException('Неправильный код', 400);
        }
        return true;
    }

    private function isValidPrice(string $price): bool {
        $isValid = preg_match('/^\d+\.\d{2}$/', $price);
        if (!$isValid) {
            throw new AppException('Неправильная цена', 400);
        }
        return true;
    }

    private function isValidName(string $name): bool {
        if (mb_strlen($name) < self::NAME_MIN_SIZE or mb_strlen($name) > self::NAME_MAX_SIZE) {
            throw new AppException('Неправильное имя', 400);
        }
        return true;
    }

    private function isValidDescription(string $name):bool {
        if (strlen($name) > self::DESCRIPTION_MAX_SIZE) {
            throw new AppException('Неправильное описание', 400);
        }
        return true;
    }

    private function isValidAmount(int $amount):bool {
        if ($amount < 0) {
            throw new AppException('Неправильное количество', 400);
        }
        return true;
    }

    private function isValidStatus(int $status):bool {
        if ($status != 0 and $status != 1) {
            throw new AppException('Неправильный статус', 400);
        }
        return true;
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

    public function isValidProduct(): bool {
        $this->isValidCode($this->code);
        $this->isValidPrice($this->price);
        $this->isValidName($this->name);
        $this->isValidDescription($this->description);
        $this->isValidAmount($this->amount_available);
        $this->isValidStatus($this->status);
        return true;
    }
}
