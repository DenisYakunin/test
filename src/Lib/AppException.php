<?php

namespace App\Lib;

use DateTime;
use DateTimeZone;
use Exception;

class AppException extends Exception
{
    /**
     * @throws Exception
     */
    public function logException()
    {
        $date = new DateTime('now', new DateTimeZone('Europe/Moscow'));
        if (!file_exists(__DIR__ . '/../../log')) {
            mkdir(__DIR__ . '/../../log');
        }
        file_put_contents(__DIR__ . '/../../log/exception.log', $date->format('Y-m-d H:i:s') . ': "' . $this->getMessage() . '"' . PHP_EOL, FILE_APPEND);
    }

    public static function responseException(int $code)
    {
        http_response_code($code);
        switch ($code) {
            case 400:
                echo 'Некоректные параметры запроса';
                break;
            case 404:
                echo 'Страница не найдена';
                break;
            case 401:
                echo 'Требуется авторизвция';
                break;
        }
    }
}