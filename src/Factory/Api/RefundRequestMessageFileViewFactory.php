<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory\Api;

use Sylius\RefundPlugin\Entity\RefundRequestMessageFileInterface;
use Sylius\RefundPlugin\View\RefundRequest\RefundRequestMessageFileView;

final class RefundRequestMessageFileViewFactory implements RefundRequestMessageFileViewFactoryInterface
{
    public function create(RefundRequestMessageFileInterface $refundRequestMessageFile): RefundRequestMessageFileView
    {
        /** @var RefundRequestMessageFileView $refundRequestMessageFileView */
        $refundRequestMessageFileView = new RefundRequestMessageFileView();

        $refundRequestMessageFileView->fileName = $refundRequestMessageFile->getFileName();
        $refundRequestMessageFileView->hash = $refundRequestMessageFile->getHash();
        $refundRequestMessageFileView->mimeType = $refundRequestMessageFile->getMimeType();

        return $refundRequestMessageFileView;
    }
}
