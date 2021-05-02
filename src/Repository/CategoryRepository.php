<?php

declare(strict_types=1);

namespace App\Repository;

class CategoryRepository extends BaseRepository
{
    protected string $table = 'categories';

    public function getCategory(string $slug): ?array
    {
        $result = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->table)
            ->where('slug = :slug')
            ->setParameter('slug', $slug)
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchAssociative();

        return $result === false ? null : $result;
    }

    public function getCategories(): array
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->table)
            ->orderBy('number')
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
