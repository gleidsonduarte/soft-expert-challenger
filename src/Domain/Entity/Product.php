<?php

namespace SoftExpert\Market\Domain\Entity;

use DateTime;
use DomainException;

class Product
{
    private ?int $id;
    private string $description;
    private ProductType $productType;
    private string $brand;
    private float $price;
    private int $quantity;
    private string $ean;
    private DateTime $entryDate;
    private DateTime $dueDate;

    public function __construct(
        string $description,
        ProductType $productType,
        string $brand,
        float $price,
        int $quantity,
        string $ean,
        DateTime $entryDate,
        DateTime $dueDate,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->description = $description;
        $this->productType = $productType;
        $this->brand = $brand;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->ean = $ean;
        $this->entryDate = $entryDate;
        $this->dueDate = $dueDate;
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getProductType(): ProductType
    {
        return $this->productType;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getEAN(): string
    {
        return $this->ean;
    }

    public function getEntryDate(): string
    {
        return $this->entryDate->format('Y-m-d');
    }

    public function getDueDate(): string
    {
        return $this->dueDate->format('Y-m-d');
    }
}
