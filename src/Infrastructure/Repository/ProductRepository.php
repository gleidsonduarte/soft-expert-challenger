<?php

namespace SoftExpert\Market\Infrastructure\Repository;

use DateTime;
use DomainException;
use PDO, PDOStatement;
use RuntimeException;
use SoftExpert\Market\Domain\Entity\{Product, ProductType};
use SoftExpert\Market\Domain\Repository\ProductRepositoryInterface;
use Throwable;

class ProductRepository implements ProductRepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function allProducts(): array
    {
        $sqlQuery = "SELECT *
                    FROM market.product AS p
                    INNER JOIN market.product_type AS pt
                        on pt.product_type_id = p.product_type_id
                    ORDER BY p.product_id;";

        $statement = $this->connection->query($sqlQuery);

        return $this->hydrateProductList($statement);
    }

    private function hydrateProductList(PDOStatement $statement): array
    {
        $dataProductList = $statement->fetchAll();
        $productList = [];

        foreach ($dataProductList as $product) {
            $productType = new ProductType(
                $product['name'],
                $product['tax_percentage'],
                $product['product_type_id']
            );

            $productList[] = new Product(
                $product['description'],
                $productType,
                $product['brand'],
                $product['price'],
                $product['quantity'],
                $product['ean'],
                new DateTime($product['entry_date']),
                new DateTime($product['due_date']),
                $product['product_id']
            );
        }

        return $productList;
    }

    public function save(Product $product): bool
    {
        $selectQuery = "SELECT *FROM market.product WHERE description = :description;";

        $statement = $this->connection->prepare($selectQuery);
        $statement->bindValue(':description', $product->getDescription());
        $statement->execute();

        if ($statement->rowCount() > 0) {
            throw new DomainException('Esse produto já existe!');
        }

        if ($product->getId() === null) {
            return $this->insert($product);
        }

        return $this->update($product);
    }

    private function insert(Product $product): bool
    {
        $insertQuery = 'INSERT INTO market.product(
                            description,
                            product_type_id,
                            brand,
                            price,
                            quantity,
                            ean,
                            entry_date,
                            due_date
                        ) VALUES (
                            :description,
                            :product_type_id,
                            :brand,
                            :price,
                            :quantity,
                            :ean,
                            :entry_date,
                            :due_date
                        );';

        $statement = $this->connection->prepare($insertQuery);

        $success = $statement->execute([
            ':description'     => $product->getDescription(),
            ':product_type_id' => $product->getProductType()->getId(),
            ':brand'           => $product->getBrand(),
            ':price'           => $product->getPrice(),
            ':quantity'        => $product->getQuantity(),
            ':ean'             => $product->getEAN(),
            ':entry_date'      => $product->getEntryDate(),
            ':due_date'        => $product->getDueDate()
        ]);

        if ($success) {
            $product->defineId($this->connection->lastInsertId());
        }

        return $success;
    }

    private function update(Product $product): bool
    {
        $updateQuery = 'UPDATE market.product
                        SET description     = :description,
                            product_type_id = :product_type_id,
                            brand           = :brand,
                            price           = :price,
                            quantity        = :quantity,
                            ean             = :ean,
                            entry_date      = :entry_date,
                            due_date        = :due_date
                        WHERE product_id = :product_id;';

        $statement = $this->connection->prepare($updateQuery);
        $statement->bindValue(':product_id', $product->getId());
        $statement->bindValue(':description', $product->getDescription());
        $statement->bindValue(':product_type_id', $product->getProductType()->getId());
        $statement->bindValue(':brand', $product->getBrand());
        $statement->bindValue(':price', $product->getPrice());
        $statement->bindValue(':quantity', $product->getQuantity());
        $statement->bindValue(':ean', $product->getEAN());
        $statement->bindValue(':entry_date', $product->getEntryDate());
        $statement->bindValue(':due_date', $product->getDueDate());

        return $statement->execute();
    }

    public function delete(Product $product): bool
    {
        $deleteQuery = 'DELETE FROM market.product
                        WHERE product_id = :product_id;';

        $statement = $this->connection->prepare($deleteQuery);
        $statement->bindValue(':product_id', $product->getId());

        try {
            return $statement->execute();
        } catch (Throwable $throwable) {
            throw new RuntimeException('Não foi possível excluir esse produto.');
        }
    }

    public function sell(array $products)
    {
        foreach ($products as $product) {
            $productId = intval($product['productId']);
            $quantityMinusSoldAmount = intval($product['quantity']) - intval($product['soldAmount']);
            $soldAmount = intval($product['soldAmount']);
            $price = intval($product['price']);

            $updateQuery = 'UPDATE market.product
                            SET quantity = :quantityMinusSoldAmount
                            WHERE product_id = :productId;';

            $statementUpdate = $this->connection->prepare($updateQuery);
            $statementUpdate->bindValue(':productId', $productId);
            $statementUpdate->bindValue(':quantityMinusSoldAmount', $quantityMinusSoldAmount);
            $statementUpdate->execute();

            $insertQuery = 'INSERT INTO market.product_sell(
                                product_id,
                                price,
                                sold_amount
                            ) VALUES (
                                :product_id,
                                :price,
                                :sold_amount
                            );';

            $statementInsert = $this->connection->prepare($insertQuery);
            $statementInsert->execute([
                ':product_id'   => $productId,
                ':price'        => $price,
                ':sold_amount'  => $soldAmount
            ]);
        }
    }
}
