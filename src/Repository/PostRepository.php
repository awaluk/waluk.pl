<?php

declare(strict_types=1);

namespace App\Repository;

class PostRepository extends BaseRepository
{
    protected string $table = 'posts';

    public function getPosts(int $categoryId = null): array
    {
        $query = $this->connection->createQueryBuilder()
            ->select(['p.title', 'p.slug', 'p.date', 'p.description'])
            ->from($this->table, 'p')
            ->orderBy('date', 'desc');
        if ($categoryId !== null) {
            $query->where('p.category_id = :category')->setParameter('category', $categoryId);
        } else {
            $query->addSelect(['c.name as category_name', 'c.slug as category_slug'])
                ->join('p', 'categories', 'c', 'p.category_id = c.id');
        }
        $query->executeQuery();

        return $query->fetchAllAssociative();
    }

    public function getPost(string $slug, int $categoryId = null): ?array
    {
        $query = $this->connection->createQueryBuilder()
            ->setMaxResults(1)
            ->select('*')
            ->from($this->table)
            ->where('slug = :slug')
            ->setParameter('slug', $slug);
        if ($categoryId !== null) {
            $query->andWhere('category_id = :category')->setParameter('category', $categoryId);
        }
        $result = $query->fetchAssociative();

        return $result === false ? null : $result;
    }

    public function create(array $data): bool
    {
        $query = $this->connection->createQueryBuilder()
            ->insert($this->table);
        $number = 0;
        foreach ($data as $field => $value) {
            $query->setValue($field, '?')->setParameter($number, $value);
            $number++;
        }

        return $query->executeStatement() === 1;
    }

    public function update(int $id, array $data): bool
    {
        $query = $this->connection->createQueryBuilder()
            ->update($this->table)
            ->where('id = :id')
            ->setParameter('id', $id);
        $number = 0;
        foreach ($data as $field => $value) {
            $query->set($field, '?')->setParameter($number, $value);
            $number++;
        }

        return $query->executeStatement() === 1;
    }
}
