<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Raketa\BackendTestTask\Repository\Entity\Product;

class ProductRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $uuid
     * @return Product
     * @throws Exception
     */
    public function getByUuid(string $uuid): Product
    {
        $row = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('products')
            ->where('uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->fetchOne();

        if (empty($row)) {
            throw new \ErrorException('Product not found');
        }

        return $this->make($row);
    }

    public function getByCategory(string $category): array
    {
        return array_map(
            static fn (array $row): Product => $this->make($row),
            $this->connection->createQueryBuilder()
                ->select('id')
                ->from('products')
                ->where('is_active = 1')
                ->andWhere('category = :category')
                ->setParameter('category', $category)
                ->fetchAllAssociative()
        );
    }

    private function make(array $row): Product
    {
        return Product::create(...$row);
    }
}
