<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Uploader;

use Sylius\RefundPlugin\Entity\RefundRequestMessageFileInterface;

interface RefundRequestMessageFileUploaderInterface
{
    public function upload(RefundRequestMessageFileInterface $refundRequestMessageFile): void;
}
