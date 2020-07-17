<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Repository;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface RefundRequestRepositoryInterface extends RepositoryInterface
{
    public function findByShopUser(ShopUserInterface $shopUser): array;

    public function findByOrder(OrderInterface $order): array;
}
