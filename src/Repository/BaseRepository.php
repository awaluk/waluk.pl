<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\DBAL\Connection;

abstract class BaseRepository
{
    protected string $table = '';

    public function __construct(protected Connection $connection)
    {
    }
}
