<?php

use App\Core\Controller;
use App\Lib\FactoryOfFileFactories;
use App\Lib\AppException;

class ProductController extends Controller
{
    protected Storage $storageModel;
    protected array $products;

    public function getProducts(): void {
        $this->storageModel = $this->loadModel('Storage', '/app/storage.txt');
        $this->products = $this->storageModel->getProducts();
        $this->view->render('Products/default', $this->products);
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
        $this->storageModel = $this->loadModel('Storage', '/app/storage.txt');
        $this->products = $this->storageModel->getProducts();

        $product = $this->loadModel('Product', $arr);
        $product->isValidProduct();
        $this->products[] = $product;

        $this->storageModel->saveProducts($this->products);
        $this->view->render('Products/default', $this->products);
    }

    public function getProduct(int $id): void {
        $this->storageModel = $this->loadModel('Storage', '/app/storage.txt');
        $this->products = $this->storageModel->getProducts();
        if (!isset($this->products[$id])) {
            throw new AppException('Некоректный id', 400);
        }
        $this->view->render('Products/default', $this->products[$id]);
    }

    public function deleteProduct(int $id): void {
        $this->storageModel = $this->loadModel('Storage', '/app/storage.txt');
        $this->products = $this->storageModel->getProducts();
        if (!isset($this->products[$id])) {
            throw new AppException('Некоректный id', 400);
        }
        unset($this->products[$id]);
        $this->storageModel->saveProducts($this->products);
        $this->view->render('Products/default', $this->products);
    }

    public function updateProduct(int $id): void {
        $this->storageModel = $this->loadModel('Storage', '/app/storage.txt');
        $this->products = $this->storageModel->getProducts();
        if (!isset($this->products[$id])) {
            throw new AppException('Некоректный id', 400);
        }
        parse_str(file_get_contents('php://input'), $PUT);
        $product = $this->loadModel('Product', $PUT);
        $product->isValidProduct();
        $this->products[$id] = $product;

        $this->storageModel->saveProducts($this->products);
        $this->view->render('Products/default', $this->products);
    }

    public function updateProductParam(int $id): void {
        $this->storageModel = $this->loadModel('Storage', '/app/storage.txt');
        $this->products = $this->storageModel->getProducts();
        if (!isset($this->products[$id])) {
            throw new AppException('Некоректный id', 400);
        }
        parse_str(file_get_contents('php://input'), $PATCH);

        if (isset($PATCH['price'])) {
            $this->products[$id]['price'] = $PATCH['price'];
        }

        if (isset($PATCH['amount_available'])) {
            $this->products[$id]['amount_available'] = $PATCH['amount_available'];
        }

        if (isset($PATCH['status'])) {
            $this->products[$id]['status'] = $PATCH['status'];
        }
        $this->storageModel->saveProducts($this->products);
        $this->view->render('Products/default', $this->products);
    }

    public function getMyProducts(): void {
        if (!$this->hasAccess(false)) {
            throw new AppException('Требуется авторизация', 401);
        }
        $this->storageModel = $this->loadModel('Storage', '/app/storage.txt');
        $this->products = $this->storageModel->getProducts();
        $this->view->render('Products/default', $this->products);
    }

    private function hasAccess(bool $access): bool {
        return $access;
    }
}