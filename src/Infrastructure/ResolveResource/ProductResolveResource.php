<?php

use SoftExpert\Market\Domain\Entity\Product;
use SoftExpert\Market\Domain\Service\ProductService;
use SoftExpert\Market\Domain\Service\ProductTypeService;
use SoftExpert\Market\Infrastructure\Persistence\PostgreConnectionCreator;
use SoftExpert\Market\Infrastructure\Repository\ProductRepository;
use SoftExpert\Market\Infrastructure\Repository\ProductTypeRepository;

require_once '../../../vendor/autoload.php';

$connection = PostgreConnectionCreator::createConnection();

$productTypeRepository = new ProductTypeRepository($connection);
$productTypeService = new ProductTypeService($productTypeRepository);

$productRepository = new ProductRepository($connection);
$productService = new ProductService($productRepository);

switch ($_POST['function']) {
    case 'saveProduct':
        if (empty($_POST['product']['id'])) {
            $_POST['product']['id'] = null;
        }

        $productType = $productTypeService->findProductTypeByName(
            $_POST['product']['type']
        );

        $product = new Product(
            $_POST['product']['description'],
            $productType,
            $_POST['product']['brand'],
            $_POST['product']['price'],
            $_POST['product']['quantity'],
            $_POST['product']['ean'],
            new DateTime($_POST['product']['entryDate']),
            new DateTime($_POST['product']['dueDate']),
            $_POST['product']['id']
        );

        return $productService->saveProduct($product);
    case 'deleteProduct':
        $productType = $productTypeService->findProductTypeByName(
            $_POST['product']['type']
        );

        $product = new Product(
            $_POST['product']['description'],
            $productType,
            $_POST['product']['brand'],
            $_POST['product']['price'],
            $_POST['product']['quantity'],
            $_POST['product']['ean'],
            new DateTime($_POST['product']['entryDate']),
            new DateTime($_POST['product']['dueDate']),
            $_POST['product']['id']
        );

        return $productService->deleteProduct($product);
    case 'productSell':
        return $productService->sellProduct($_POST['productsSold']);
}
