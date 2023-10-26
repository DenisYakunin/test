<?php

namespace App\Lib\Validators;
use App\Lib\AppException;

class ProductSchemeValidator
{
    /**
     * @throws AppException
     */
    public function isValidScheme(array $scheme): bool {
        if (count($scheme) != 6 ) {
            throw new AppException('Переданы не все параметры', 400);
        }

        if (!isset($scheme['code'])) {
            throw new AppException('Код отсутсвует', 400);
        }

        if (!isset($scheme['price'])) {
            throw new AppException('Цена отсутсвует', 400);
        }

        if (!isset($scheme['name'])) {
            throw new AppException('Имя товара отсутсвует', 400);
        }

        if (!isset($scheme['description'])) {
            throw new AppException('Описание товара отсутсвует', 400);
        }

        if (!isset($scheme['amount_available'])) {
            throw new AppException('Количество отсутсвует', 400);
        }

        if (!isset($scheme['status'])) {
            throw new AppException('Статус товара отсутсвует', 400);
        }
        return true;
    }
}