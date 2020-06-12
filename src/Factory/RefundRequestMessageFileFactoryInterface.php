<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory;

use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\RefundPlugin\Entity\RefundRequestMessageFileInterface;
use Sylius\RefundPlugin\Entity\RefundRequestMessageInterface;

interface RefundRequestMessageFileFactoryInterface extends FactoryInterface
{
    public function createForMessage(RefundRequestMessageInterface $refundRequestMessage): RefundRequestMessageFileInterface;
}
