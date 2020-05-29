<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Request\Api;

use Sylius\RefundPlugin\Command\Api\CommandInterface;
use Symfony\Component\HttpFoundation\Request;
use Sylius\RefundPlugin\Command\Api\CreateCustomerRefundRequest;

class CreateCustomerRefundRequestRequest
{
    /** @var mixed */
    protected $orderId;

    /** @var mixed */
    protected $orderItemUnitId;

    /** @var string */
    protected $applicationReasonCode;

    public function __construct(
        Request $request
    ) {
        $this->orderId = $request->attributes->get('orderId');
        $this->orderItemUnitId = $request->attributes->get('orderItemUnitId');
        $this->applicationReasonCode = $request->request->get('applicationReasonCode');
    }

    public function getCommand(): CommandInterface
    {
        return new CreateCustomerRefundRequest(
            $this->orderId,
            $this->orderItemUnitId,
            $this->applicationReasonCode
        );
    }
}
