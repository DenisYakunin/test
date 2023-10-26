<?php

namespace App\Lib\Validators;
use App\Lib\AppException;
use Product;

class ProductValidator
{
    private const NAME_MAX_SIZE = 64;
    private const NAME_MIN_SIZE = 5;
    private const DESCRIPTION_MAX_SIZE = 300;

    /**
     * @throws AppException
     */
    public function isValidCode(string $code): bool {
        $pattern = preg_match('/^\d{0,3}-\d+$/',$code);
        if ((strlen($code) > 10) or !$pattern) {
            throw new AppException('Неправильный код', 400);
        }
        return true;
    }

    /**
     * @throws AppException
     */
    public function isValidPrice(string $price): bool {
        $isValid = preg_match('/^\d+\.\d{2}$/', $price);
        if (!$isValid) {
            throw new AppException('Неправильная цена', 400);
        }
        return true;
    }

    /**
     * @throws AppException
     */
    public function isValidName(string $name): bool {
        if (mb_strlen($name) < self::NAME_MIN_SIZE or mb_strlen($name) > self::NAME_MAX_SIZE) {
            throw new AppException('Неправильное имя', 400);
        }
        return true;
    }

    /**
     * @throws AppException
     */
    public function isValidDescription(string $name):bool {
        if (strlen($name) > self::DESCRIPTION_MAX_SIZE) {
            throw new AppException('Неправильное описание', 400);
        }
        return true;
    }

    /**
     * @throws AppException
     */
    public function isValidAmount(int $amount):bool {
        if ($amount < 0) {
            throw new AppException('Неправильное количество', 400);
        }
        return true;
    }

    /**
     * @throws AppException
     */
    public function isValidStatus(int $status):bool {
        if ($status != 0 and $status != 1) {
            throw new AppException('Неправильный статус', 400);
        }
        return true;
    }

    /**
     * @throws AppException
     */
    public function isValidProduct(Product $product): bool {
        $this->isValidCode($product->code);
        $this->isValidPrice($product->price);
        $this->isValidName($product->name);
        $this->isValidDescription($product->description);
        $this->isValidAmount($product->amount_available);
        $this->isValidStatus($product->status);
        return true;
    }
}