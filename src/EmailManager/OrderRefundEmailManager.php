<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\EmailManager;

use Sylius\Component\Mailer\Sender\SenderInterface;
use Sylius\RefundPlugin\Entity\RefundRequestInterface;

final class OrderRefundEmailManager implements OrderRefundEmailManagerInterface
{
    /** @var SenderInterface */
    private $emailSender;

    public function __construct(
        SenderInterface $emailSender
    )
    {
        $this->emailSender = $emailSender;
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
