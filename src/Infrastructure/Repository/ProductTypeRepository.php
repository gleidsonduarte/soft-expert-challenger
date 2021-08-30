<?php

namespace SoftExpert\Market\Infrastructure\Repository;

use DomainException, RuntimeException, Throwable;
use PDO, PDOStatement;
use SoftExpert\Market\Domain\Entity\ProductType;
use SoftExpert\Market\Domain\Repository\ProductTypeRepositoryInterface;

class ProductTypeRepository implements ProductTypeRepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findProductTypeByName(string $name): ProductType
    {
        $selectQuery = 'SELECT * FROM market.product_type WHERE name = :name;';

        $statement = $this->connection->prepare($selectQuery);
        $statement->bindValue(':name', $name);
        $statement->execute();

        return $this->hydrateProductType($statement);
    }

    private function hydrateProductType($statement): ProductType
    {
        $dataProductType = $statement->fetchAll();

        return new ProductType(
            $dataProductType[0]['name'],
            $dataProductType[0]['tax_percentage'],
            $dataProductType[0]['product_type_id']
        );
    }

    public function allProductsType(): array
    {
        $selectQuery = 'SELECT * FROM market.product_type ORDER BY product_type_id;';

        $statement = $this->connection->query($selectQuery);

        return $this->hydrateProductTypeList($statement);
    }

    private function hydrateProductTypeList(PDOStatement $statement): array
    {
        $dataProductTypeList = $statement->fetchAll();
        $productTypeList = [];

        foreach ($dataProductTypeList as $productType) {
            $productTypeList[] = new ProductType(
                $productType['name'],
                $productType['tax_percentage'],
                $productType['product_type_id']
            );
        }

        return $productTypeList;
    }

    public function save(ProductType $productType): bool
    {
        $selectQuery = "SELECT * FROM market.product_type WHERE name = :name";

        $statement = $this->connection->prepare($selectQuery);
        $statement->bindValue(':name', $productType->getName());
        $statement->execute();

        if ($statement->rowCount() > 0) {
            throw new DomainException('Esse tipo de produto já existe!');
        }

        if ($productType->getId() === null) {
            return $this->insert($productType);
        }

        return $this->update($productType);
    }

    private function insert(ProductType $productType): bool
    {
        $insertQuery = 'INSERT INTO market.product_type(name, tax_percentage)
                        VALUES (:name, :tax_percentage);';

        $statement = $this->connection->prepare($insertQuery);

        $success = $statement->execute([
            ':name' =>         $productType->getName(),
            ':tax_percentage' => $productType->getProductTaxPercentage()
        ]);
       
        if ($success) {
            $productType->defineId($this->connection->lastInsertId());
        }

        return $success;
    }

    private function update(ProductType $product): bool
    {
        $updateQuery = 'UPDATE market.product_type
                        SET name = :name,
                            tax_percentage = :tax_percentage
                        WHERE product_type_id = :product_type_id;';

        $statement = $this->connection->prepare($updateQuery);
        $statement->bindValue(':name', $product->getName());
        $statement->bindValue(':tax_percentage', $product->getProductTaxPercentage());
        $statement->bindValue(':product_type_id', $product->getId());

        return $statement->execute();
    }

    public function delete(ProductType $product): bool
    {
        $deleteQuery = 'DELETE FROM market.product_type
                        WHERE product_type_id = :product_type_id;';

        $statement = $this->connection->prepare($deleteQuery);
        $statement->bindValue(':product_type_id', $product->getId());

        $response = null;
        try {
            $response = $statement->execute();
        } catch (Throwable $throwable) {
            throw new RuntimeException('Não foi possível excluir esse tipo de produto.');
        }

        return $response;
    }
}
