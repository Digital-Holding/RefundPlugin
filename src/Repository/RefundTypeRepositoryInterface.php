<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface RefundTypeRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(string $localeCode): QueryBuilder;
}
