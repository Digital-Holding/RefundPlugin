<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\EmailManager;

use Sylius\Bundle\AdminBundle\EmailManager\OrderEmailManagerInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Sylius\RefundPlugin\Entity\RefundRequestInterface;

final class OrderRefundEmailManager
{
    /** @var SenderInterface */
    private $emailSender;

    /** @var OrderEmailManagerInterface */
    private $innerOrderEmailManager;

    public function __construct(
        SenderInterface $emailSender,
        OrderEmailManagerInterface $innerOrderEmailManager
    )
    {
        $this->emailSender = $emailSender;
        $this->innerOrderEmailManager = $innerOrderEmailManager;
    }

    public function sendRefundAcceptedEmail(RefundRequestInterface $refundRequest): void
    {
        $order = $refundRequest->getOrder();

        $this->emailSender->send(
            RefundEmails::REFUND_REQUEST_ACCEPTED,
            [$order->getCustomer()->getEmail()],
            ['order' => $order, 'refund_request' => $refundRequest]
        );
    }
}
