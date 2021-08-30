<?php

namespace SoftExpert\Market\Domain\Entity;

use DomainException;

class ProductType
{
    private ?int $id;
    private string $name;
    private float $productTaxPercentage;

    public function __construct(
        string $name,
        float $productTaxPercentage,
        ?int $id = null
    ) {
        $this->name = $name;
        $this->productTaxPercentage = $productTaxPercentage;
        $this->id = $id;
    }

    public function defineId(int $id): void
    {
        if (!is_null($this->id)) {
            throw new DomainException('Você só poder definir o ID uma vez');
        }

        $this->id = $id;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProductTaxPercentage(): float
    {
        return $this->productTaxPercentage;
    }
}
