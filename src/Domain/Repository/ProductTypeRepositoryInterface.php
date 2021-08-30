<?php

namespace SoftExpert\Market\Domain\Repository;

use SoftExpert\Market\Domain\Entity\ProductType;

interface ProductTypeRepositoryInterface
{
    public function allProductsType(): array;
    public function save(ProductType $product): bool;
    public function delete(ProductType $product): bool;
}
