<?php

use src\Core\Controller;
use src\Lib\AppException;
use src\Lib\ProductMapper;
use src\Lib\Validators\ProductSchemeValidator;
use src\Lib\Validators\ProductValidator;
use src\Lib\RequestDataExtractor;

class ProductController extends Controller
{
    private ProductMapper $db;
    private Product $product;
    private ProductValidator $productValidator;
    private RequestDataExtractor $requestDataExtractor;
    private ProductSchemeValidator $productSchemeValidator;

    public function __construct(
        ProductMapper $db,
        Product $productModel,
        ProductValidator $productValidator,
        ProductSchemeValidator $productSchemeValidator,
        RequestDataExtractor $requestDataExtractor
    ) {
        parent::__construct();
        $this->db = $db;
        $this->product = $productModel;
        $this->productValidator = $productValidator;
        $this->requestDataExtractor = $requestDataExtractor;
        $this->productSchemeValidator = $productSchemeValidator;
    }

    /**
     * @throws AppException
     */
    public function getProducts(): void {
        $products = $this->db->selectAllProducts();
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

        $this->db->insertProduct($this->product);

        $this->getProducts();
    }

    /**
     * @throws AppException
     */
    public function getProduct(int $id): void {
        $products = $this->db->selectProductById($id);
        if (empty($products)) {
            throw new AppException('Некоректный id', 400);
        }
        $this->view->render('Products/default', $products);
    }

    /**
     * @throws AppException
     */
    public function deleteProduct(int $id): void {
        $products = $this->db->selectProductById($id);
        if (empty($products)) {
            throw new AppException('Некоректный id', 400);
        }

        $this->db->deleteProduct($id);

        $this->getProducts();
    }

    /**
     * @throws AppException
     */
    public function updateProduct(int $id): void {
        $products = $this->db->selectProductById($id);
        if (empty($products)) {
            throw new AppException('Некоректный id', 400);
        }

        $extractedParams = $this->requestDataExtractor->extractRequestData();
        $this->productSchemeValidator->isValidScheme($extractedParams);

        $this->product->createProduct($extractedParams);
        $this->productValidator->isValidProduct($this->product);

        $this->db->updateProduct($id, $this->product);

        $this->getProducts();
    }

    /**
     * @throws AppException
     */
    public function updateProductParam(int $id): void {
        $products = $this->db->selectProductById($id);
        if (empty($products)) {
            throw new AppException('Некоректный id', 400);
        }

        $extractedParams = $this->requestDataExtractor->extractRequestData();

        if (isset($extractedParams['price'])) {
            $this->productValidator->isValidPrice($extractedParams['price']);
            $this->db->updateProductPrice($id, $extractedParams['price']);
        }

//        if (isset($extractedParams['amount_available'])) {
//            $this->productValidator->isValidAmount($extractedParams['amount_available']);
//            $products[$id]['amount_available'] = $extractedParams['amount_available'];
//        }
//
//        if (isset($extractedParams['status'])) {
//            $this->productValidator->isValidStatus($extractedParams['status']);
//            $products[$id]['status'] = $extractedParams['status'];
//        }
        $this->getProducts();
    }

    /**
     * @throws AppException
     */
    public function getMyProducts(): void {
        if (!$this->hasAccess(false)) {
            throw new AppException('Требуется авторизация', 401);
        }
        $this->getProducts();
    }

    private function hasAccess(bool $access): bool {
        return $access;
    }
}