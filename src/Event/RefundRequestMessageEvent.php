<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Event;

use Sylius\RefundPlugin\Entity\RefundRequestInterface;
use Symfony\Contracts\EventDispatcher\Event;

final class RefundRequestMessageEvent extends Event
{
    const NAME = 'dh_refund_plugin_refund_request_message';

    protected $refundRequest;

    public function __construct(RefundRequestInterface $refundRequest)
    {
        $this->refundRequest = $refundRequest;
    }

    public function getRefundRequest()
    {
        return $this->refundRequest;
    }
}
