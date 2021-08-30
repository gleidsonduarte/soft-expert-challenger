<?php

use SoftExpert\Market\Domain\Entity\ProductType;
use SoftExpert\Market\Domain\Service\ProductTypeService;
use SoftExpert\Market\Infrastructure\Persistence\PostgreConnectionCreator;
use SoftExpert\Market\Infrastructure\Repository\ProductTypeRepository;

require_once '../../../vendor/autoload.php';

$connection = PostgreConnectionCreator::createConnection();
$productTypeRepository = new ProductTypeRepository($connection);
$productTypeService = new ProductTypeService($productTypeRepository);

switch ($_POST['function']) {
    case 'saveProductType':
        if (empty($_POST['productType']['id'])) {
            $_POST['productType']['id'] = null;
        }
        
        $productType = new ProductType(
            $_POST['productType']['name'],
            $_POST['productType']['taxPercentage'],
            $_POST['productType']['id']
        );

        return $productTypeService->saveProductType($productType);
    case 'deleteProductType':
        $productType = new ProductType(
            $_POST['productType']['name'],
            $_POST['productType']['taxPercentage'],
            $_POST['productType']['id']
        );

        return $productTypeService->deleteProductType($productType);
}
