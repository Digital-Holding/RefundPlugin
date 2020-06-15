<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory\Api;

use Sylius\RefundPlugin\Entity\RefundRequestMessageFileInterface;
use Sylius\RefundPlugin\Entity\RefundRequestMessageInterface;
use Sylius\RefundPlugin\View\RefundRequest\RefundRequestMessageView;

final class RefundRequestMessageViewFactory implements RefundRequestMessageViewFactoryInterface
{
    /** @var RefundRequestMessageFileViewFactoryInterface */
    private $refundRequestMessageFileViewFactory;

    public function __construct(
        RefundRequestMessageFileViewFactoryInterface $refundRequestMessageFileViewFactory
    )
    {
        $this->refundRequestMessageFileViewFactory = $refundRequestMessageFileViewFactory;
    }

    public function create(RefundRequestMessageInterface $refundRequestMessage): RefundRequestMessageView
    {
        /** @var RefundRequestMessageView $refundRequestMessageView */
        $refundRequestMessageView = new RefundRequestMessageView();

        $refundRequestMessageView->adminUser = $refundRequestMessage->getAdminUser();
        $refundRequestMessageView->shopUser = $refundRequestMessage->getShopUser();
        $refundRequestMessageView->message = $refundRequestMessage->getMessage();
        $refundRequestMessageView->createdAt = $refundRequestMessage->getDateTime()->format('c');

        /** @var RefundRequestMessageFileInterface $refundRequestMessageFile */
        foreach ($refundRequestMessage->getRefundRequestMessageFiles() as $refundRequestMessageFile) {
            $refundRequestMessageView->files [] = $this->refundRequestMessageFileViewFactory->create($refundRequestMessageFile);
        }

        return $refundRequestMessageView;
    }
}
