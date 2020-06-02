<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class ApplicationReasonRepository extends EntityRepository implements ApplicationReasonRepositoryInterface
{
    public function createListQueryBuilder(string $localeCode): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->addSelect('translation')
            ->leftJoin('o.translations', 'translation', 'WITH', 'translation.locale = :localeCode')
            ->setParameter('localeCode', $localeCode)
            ;
    }

    public function findByType(string $type): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.type = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult()
            ;
    }
}
