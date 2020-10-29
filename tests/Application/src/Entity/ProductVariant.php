<?php

declare(strict_types=1);

namespace Tests\Sylius\RefundPlugin\Application\src\Entity;

use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ProductVariantInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_variant")
 */
class ProductVariant extends BaseProductVariant implements ProductVariantInterface
{
    use VisibleAwareTrait;
}
