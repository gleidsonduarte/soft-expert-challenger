<?php

namespace SoftExpert\Market\Domain\Repository;

use SoftExpert\Market\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    public function allProducts(): array;
    public function save(Product $product): bool;
    public function delete(Product $product): bool;
}
