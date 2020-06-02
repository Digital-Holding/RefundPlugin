<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory\Api;

use Sylius\RefundPlugin\Entity\RefundRequestInterface;
use Sylius\RefundPlugin\View\RefundRequest\RefundRequestView;

final class RefundRequestViewFactory implements RefundRequestViewFactoryInterface
{
    /** @var RefundRequestMessageViewFactoryInterface */
    private $refundRequestMessageViewFactory;

    public function __construct(RefundRequestMessageViewFactoryInterface $refundRequestMessageViewFactory)
    {
        $this->refundRequestMessageViewFactory = $refundRequestMessageViewFactory;
    }

    public function create(RefundRequestInterface $refundRequest): RefundRequestView
    {
        /** @var RefundRequestView $refundRequestView */
        $refundRequestView = new RefundRequestView();

        $refundRequestView->id = $refundRequest->getId();
        $refundRequestView->applicationReason = $refundRequest->getApplicationReason()->getName();
        $refundRequestView->applicationReasonType = $refundRequest->getApplicationReason()->getType();
        $refundRequestView->orderNumber = $refundRequest->getOrder()->getNumber();
        $refundRequestView->createdAt = $refundRequest->getCreatedAt()->format('c');
        $refundRequestView->state = $refundRequest->getState();

        return $refundRequestView;
    }

    public function createWithMessages(RefundRequestInterface $refundRequest): RefundRequestView
    {
        /** @var RefundRequestView $refundRequestView */
        $refundRequestView = $this->create($refundRequest);

        foreach ($refundRequest->getMessages() as $message) {
            $refundRequestView->messages [] = $this->refundRequestMessageViewFactory->create($message);
        }

        return $refundRequestView;
    }
}
