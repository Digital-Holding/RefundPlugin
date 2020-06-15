<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory\Api;

use Sylius\RefundPlugin\Entity\RefundRequestMessageFileInterface;
use Sylius\RefundPlugin\View\RefundRequest\RefundRequestMessageFileView;

interface RefundRequestMessageFileViewFactoryInterface
{
    public function create(RefundRequestMessageFileInterface $refundRequestMessageFile): RefundRequestMessageFileView;
}
