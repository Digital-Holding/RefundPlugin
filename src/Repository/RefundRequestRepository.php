<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShopUserInterface;

class RefundRequestRepository extends EntityRepository implements RefundRequestRepositoryInterface
{
    public function findByShopUser(ShopUserInterface $shopUser): array
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.shopUser', 'shopUser')
            ->andWhere('shopUser = :shopUser')
            ->setParameter('shopUser', $shopUser)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByOrder(OrderInterface $order): array
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.order', 'order')
            ->andWhere('order = :order')
            ->setParameter('order', $order)
            ->getQuery()
            ->getResult()
            ;
    }
}
