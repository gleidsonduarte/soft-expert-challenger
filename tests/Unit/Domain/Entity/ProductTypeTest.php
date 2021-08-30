<?php

namespace SoftExpert\Market\Tests\Unit\Domain\Entity;

use PHPUnit\Framework\TestCase;
use SoftExpert\Market\Domain\Entity\ProductType;

/**
 * @group unit_tests
 */
class ProductTypeTest extends TestCase
{
    /**
     * @dataProvider createNewProductType
     */
    public function testCreateNewProductType(ProductType $productType): void
    {
        self::assertEquals(null, $productType->getId());
        self::assertEquals('CARNES', $productType->getName());
        self::assertEquals(10.35, $productType->getProductTaxPercentage());
        self::assertInstanceOf(ProductType::class, $productType);
    }

    public function createNewProductType(): array
    {
        return [
            'success' => [
                new ProductType(
                    'CARNES',
                    10.35,
                    null
                )
            ]
        ];
    }
}
