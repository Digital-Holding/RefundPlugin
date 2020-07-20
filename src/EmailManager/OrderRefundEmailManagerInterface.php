<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\EmailManager;

use Sylius\RefundPlugin\Entity\RefundRequestInterface;

interface OrderRefundEmailManagerInterface
{
    public function sendRefundAcceptedEmail(RefundRequestInterface $refundRequest): void;
}
