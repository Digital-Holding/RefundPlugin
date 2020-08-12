<?php

declare(strict_types=1);

namespace Tests\Sylius\RefundPlugin\Application\src\Entity;

use Sylius\Component\Core\Model\Product as BaseProduct;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\RefundPlugin\Entity\DisposableTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
class Product extends BaseProduct implements ProductInterface
{
    use DisposableTrait;
}
