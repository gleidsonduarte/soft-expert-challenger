<?php

namespace SoftExpert\Market\Domain\Service;

use SoftExpert\Market\Domain\Entity\ProductType;
use SoftExpert\Market\Infrastructure\Repository\ProductTypeRepository;

class ProductTypeService
{
    private ProductTypeRepository $productTypeRepository;

    public function __construct(ProductTypeRepository $productTypeRepository)
    {
        $this->productTypeRepository = $productTypeRepository;
    }

    public function findProductTypeByName(string $name): ProductType
    {
        return $this->productTypeRepository->findProductTypeByName($name);
    }

    public function allProductsType(): array
    {
        return $this->productTypeRepository->allProductsType();
    }

    public function saveProductType(ProductType $productType): bool
    {
        return $this->productTypeRepository->save($productType);
    }

    public function deleteProductType(ProductType $productType): bool
    {
        return $this->productTypeRepository->delete($productType);
    }
}
