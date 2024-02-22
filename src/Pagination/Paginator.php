<?php

declare(strict_types=1);

namespace App\Pagination;

class Paginator
{
    public function __construct(private int $allItems, private int $currentPage, private int $perPage)
    {
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getTotalPages(): int
    {
        $total = intval(ceil($this->allItems / $this->perPage));
        if ($total <= 1) {
            return 1;
        }

        return $total;
    }

    public function getFromItem(): int
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    public function getNextPage(): ?int
    {
        if ($this->allItems > $this->currentPage * $this->perPage) {
            return $this->currentPage + 1;
        }

        return null;
    }

    public function getPreviousPage(): ?int
    {
        if ($this->currentPage > 1) {
            return $this->currentPage - 1;
        }

        return null;
    }

    public function getPagesRange(int $limit): array
    {
        $page = $this->currentPage - $limit;
        if ($page < 1) {
            $page = 1;
        }

        $pages = [];
        while ($page <= $this->currentPage + $limit) {
            $pages[] = $page;
            $page++;

            if ($page > $this->getTotalPages()) {
                break;
            }
        }

        return $pages;
    }
}
