<?php

namespace SoftExpert\Market\Tests\Unit\Domain\Entity;

use DateTime;
use PHPUnit\Framework\TestCase;
use SoftExpert\Market\Domain\Entity\Product;
use SoftExpert\Market\Domain\Entity\ProductType;

/**
 * @group unit_tests
 */
class ProductTest extends TestCase
{
    /**
     * @dataProvider createNewProduct
     */
    public function testCreateNewProduct(Product $product): void
    {
        self::assertEquals(null, $product->getId());
        self::assertEquals('Alcatra Friboi 1Kg', $product->getDescription());
        self::assertInstanceOf(ProductType::class, $product->getProductType());
        self::assertEquals('JBS', $product->getBrand());
        self::assertEquals(50.49, $product->getPrice());
        self::assertEquals(10, $product->getQuantity());
        self::assertEquals('123456789101', $product->getEAN());
        self::assertEquals('1899-11-30', $product->getEntryDate());
        self::assertEquals('1899-12-31', $product->getDueDate());
    }

    private function createMockProductType(): ProductType
    {
        return $this->createMock(ProductType::class);
    }

    public function createNewProduct(): array
    {
        return [
            'success' => [
                new Product(
                    'Alcatra Friboi 1Kg',
                    $this->createMockProductType(),
                    'JBS',
                    50.49,
                    10,
                    '123456789101',
                    new DateTime('1899-11-30'),
                    new DateTime('1899-12-31'),
                    null
                )
            ]
        ];
    }
}
