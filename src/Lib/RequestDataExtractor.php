<?php

namespace App\Lib;
use App\Lib\Factories\FactoryOfFileReaderFactories;

class RequestDataExtractor
{
    /**
     * @throws AppException
     */
    public function extractRequestData(): array {

        if (!empty($_FILES)) {
            $fileFactory = new FactoryOfFileReaderFactories();
            $file = $fileFactory->getFileReaderFactory($_FILES['file']['name'])->createFileReader();

            return $file->readProductData($_FILES['file']['tmp_name'])[$_POST['row']];
        }

        if (!empty($_POST)) {
            return $_POST;
        }

        parse_str(file_get_contents('php://input'), $data);
        if (!empty($data)) {
            return $data;
        }
        throw new AppException('Некорретные передаваемые данные', 400);
    }
}