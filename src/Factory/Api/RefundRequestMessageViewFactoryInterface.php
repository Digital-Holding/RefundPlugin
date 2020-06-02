<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory\Api;

use Sylius\RefundPlugin\Entity\RefundRequestMessageInterface;
use Sylius\RefundPlugin\View\RefundRequest\RefundRequestMessageView;

interface RefundRequestMessageViewFactoryInterface
{
    public function create(RefundRequestMessageInterface $refundRequestMessage): RefundRequestMessageView;
}
