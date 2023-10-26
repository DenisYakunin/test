<?php

use App\Core\Controller;
use App\Lib\AppException;
use App\Lib\Validators\ProductSchemeValidator;
use App\Lib\Validators\ProductValidator;
use App\Lib\RequestDataExtractor;

class ProductController extends Controller
{
    private Storage $storage;
    private Product $product;
    private ProductValidator $productValidator;
    private RequestDataExtractor $requestDataExtractor;
    private ProductSchemeValidator $productSchemeValidator;

    public function __construct(
        Storage $storageModel,
        Product $productModel,
        ProductValidator $productValidator,
        ProductSchemeValidator $productSchemeValidator,
        RequestDataExtractor $requestDataExtractor
    ) {
        parent::__construct();
        $this->storage = $storageModel;
        $this->product = $productModel;
        $this->productValidator = $productValidator;
        $this->requestDataExtractor = $requestDataExtractor;
        $this->productSchemeValidator = $productSchemeValidator;
    }

    /**
     * @throws AppException
     */
    public function getProducts(): void {
        $products = $this->storage->getProducts();
        $this->view->render('Products/default', $products);
    }

    /**
     * @throws AppException
     */
    public function addProduct(): void {

        $extractedParams = $this->requestDataExtractor->extractRequestData();
        $this->productSchemeValidator->isValidScheme($extractedParams);

        $this->product->createProduct($extractedParams);
        $this->productValidator->isValidProduct($this->product);

        $products = $this->storage->getProducts();
        $products[] = $this->product;
        $this->storage->saveProducts($products);

        $this->view->render('Products/default', $products);
    }

    /**
     * @throws AppException
     */
    public function getProduct(int $id): void {
        $products = $this->storage->getProducts();
        if (!isset($products[$id])) {
            throw new AppException('Некоректный id', 400);
        }
        $this->view->render('Products/default', $products[$id]);
    }

    /**
     * @throws AppException
     */
    public function deleteProduct(int $id): void {
        $products = $this->storage->getProducts();
        if (!isset($products[$id])) {
            throw new AppException('Некоректный id', 400);
        }
        unset($products[$id]);
        $this->storage->saveProducts($products);
        $this->view->render('Products/default', $products);
    }

    /**
     * @throws AppException
     */
    public function updateProduct(int $id): void {
        $products = $this->storage->getProducts();
        if (!isset($products[$id])) {
            throw new AppException('Некоректный id', 400);
        }

        $extractedParams = $this->requestDataExtractor->extractRequestData();
        $this->productSchemeValidator->isValidScheme($extractedParams);

        $this->product->createProduct($extractedParams);
        $this->productValidator->isValidProduct($this->product);

        $products[$id] = $this->product;
        $this->storage->saveProducts($products);

        $this->view->render('Products/default', $products);
    }

    /**
     * @throws AppException
     */
    public function updateProductParam(int $id): void {
        $products = $this->storage->getProducts();
        if (!isset($products[$id])) {
            throw new AppException('Некоректный id', 400);
        }

        $extractedParams = $this->requestDataExtractor->extractRequestData();

        if (isset($extractedParams['price'])) {
            $this->productValidator->isValidPrice($extractedParams['price']);
            $products[$id]['price'] = $extractedParams['price'];
        }

        if (isset($extractedParams['amount_available'])) {
            $this->productValidator->isValidAmount($extractedParams['amount_available']);
            $products[$id]['amount_available'] = $extractedParams['amount_available'];
        }

        if (isset($extractedParams['status'])) {
            $this->productValidator->isValidStatus($extractedParams['status']);
            $products[$id]['status'] = $extractedParams['status'];
        }
        $this->storage->saveProducts($products);
        $this->view->render('Products/default', $products);
    }

    /**
     * @throws AppException
     */
    public function getMyProducts(): void {
        if (!$this->hasAccess(false)) {
            throw new AppException('Требуется авторизация', 401);
        }
        $products = $this->storage->getProducts();
        $this->view->render('Products/default', $products);
    }

    private function hasAccess(bool $access): bool {
        return $access;
    }
}