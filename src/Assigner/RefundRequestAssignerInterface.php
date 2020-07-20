<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Assigner;

use Sylius\RefundPlugin\Entity\RefundRequestInterface;

interface RefundRequestAssignerInterface
{
    public function assignRefundProductToOrder(RefundRequestInterface $refundRequest): void;
}
