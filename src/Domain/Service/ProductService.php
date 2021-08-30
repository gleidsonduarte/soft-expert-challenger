<?php

namespace SoftExpert\Market\Domain\Service;

use SoftExpert\Market\Domain\Entity\Product;
use SoftExpert\Market\Infrastructure\Repository\ProductRepository;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function allProducts(): array
    {
        return $this->productRepository->allProducts();
    }

    public function saveProduct(Product $product): bool
    {
        return $this->productRepository->save($product);
    }

    public function deleteProduct(Product $product): bool
    {
        return $this->productRepository->delete($product);
    }

    public function sellProduct(array $sellProducts)
    {
        return $this->productRepository->sell($sellProducts);
    }
}
