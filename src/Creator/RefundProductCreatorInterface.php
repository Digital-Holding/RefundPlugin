<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Creator;

use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

interface RefundProductCreatorInterface
{
    public function createProductWithVariant(string $productName, int $price, string $unitCode): ProductVariantInterface;

    public function createVariantForProduct(ProductInterface $product): ProductVariantInterface;
}
