<?php

use App\Core\Controller;
use App\Lib\FactoryOfFileFactories;
use App\Lib\AppException;

class ProductController extends Controller
{
    protected Storage $storageModel;
    protected Product $productModel;

    public function __construct(Storage $storageModel, Product $productModel)
    {
        parent::__construct();
        $this->storageModel = $storageModel;
        $this->productModel = $productModel;
    }

    public function getProducts(): void {
        $products = $this->storageModel->getProducts();
        $this->view->render('Products/default', $products);
    }

    public function addProduct(): void {

        if (isset($_FILES['file'])) {
            $fileFactory = new FactoryOfFileFactories();
            $file = $fileFactory->getFileFactory($_FILES['file']['name'])->createFile();
            $arr = $file->toArray($_FILES['file']['tmp_name'])[$_POST['row']];
        } else {
            $arr['code'] = $_POST['code'];
            $arr['price'] = $_POST['price'];
            $arr['name'] = $_POST['name'];
            $arr['description'] = $_POST['description'];
            $arr['status'] = $_POST['status'];
            $arr['amount_available'] = $_POST['amount_available'];
        }
        $products = $this->storageModel->getProducts();
        $this->productModel->createProduct($arr);

        $this->productModel->isValidProduct();
        $products[] = $this->productModel;

        $this->storageModel->saveProducts($products);
        $this->view->render('Products/default', $products);
    }

    public function getProduct(int $id): void {
        $products = $this->storageModel->getProducts();
        if (!isset($products[$id])) {
            throw new AppException('Некоректный id', 400);
        }
        $this->view->render('Products/default', $products[$id]);
    }

    public function deleteProduct(int $id): void {
        $products = $this->storageModel->getProducts();
        if (!isset($products[$id])) {
            throw new AppException('Некоректный id', 400);
        }
        unset($products[$id]);
        $this->storageModel->saveProducts($products);
        $this->view->render('Products/default', $products);
    }

    public function updateProduct(int $id): void {
        $products = $this->storageModel->getProducts();
        if (!isset($products[$id])) {
            throw new AppException('Некоректный id', 400);
        }
        parse_str(file_get_contents('php://input'), $PUT);
        $this->productModel->createProduct($PUT);
        $this->productModel->isValidProduct();
        $products[$id] = $this->productModel;

        $this->storageModel->saveProducts($products);
        $this->view->render('Products/default', $products);
    }

    public function updateProductParam(int $id): void {
        $products = $this->storageModel->getProducts();
        if (!isset($products[$id])) {
            throw new AppException('Некоректный id', 400);
        }
        parse_str(file_get_contents('php://input'), $PATCH);

        if (isset($PATCH['price'])) {
            $products[$id]['price'] = $PATCH['price'];
        }

        if (isset($PATCH['amount_available'])) {
            $products[$id]['amount_available'] = $PATCH['amount_available'];
        }

        if (isset($PATCH['status'])) {
            $products[$id]['status'] = $PATCH['status'];
        }
        $this->storageModel->saveProducts($products);
        $this->view->render('Products/default', $products);
    }

    public function getMyProducts(): void {
        if (!$this->hasAccess(false)) {
            throw new AppException('Требуется авторизация', 401);
        }
        $products = $this->storageModel->getProducts();
        $this->view->render('Products/default', $products);
    }

    private function hasAccess(bool $access): bool {
        return $access;
    }
}