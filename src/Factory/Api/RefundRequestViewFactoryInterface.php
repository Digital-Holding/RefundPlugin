<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory\Api;

use Sylius\RefundPlugin\Entity\RefundRequestInterface;
use Sylius\RefundPlugin\View\RefundRequest\RefundRequestView;

interface RefundRequestViewFactoryInterface
{
    public function create(RefundRequestInterface $refundRequest): RefundRequestView;

    public function createWithMessages(RefundRequestInterface $refundRequest): RefundRequestView;
}
