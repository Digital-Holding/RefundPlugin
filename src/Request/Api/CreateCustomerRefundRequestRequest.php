<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Request\Api;

use Sylius\RefundPlugin\Command\Api\CommandInterface;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;
use Sylius\RefundPlugin\Command\Api\CreateCustomerRefundRequest;

class CreateCustomerRefundRequestRequest
{
    /** @var mixed */
    protected $orderId;

    /** @var mixed */
    protected $orderItemId;

    /** @var string */
    protected $applicationReasonCode;

    /** @var string */
    protected $description;

    /** @var FileBag|null */
    protected $attachments;

    public function __construct(
        Request $request
    ) {
        $this->orderId = $request->attributes->get('orderId');
        $this->orderItemId = $request->attributes->get('orderItemId');
        $this->applicationReasonCode = $request->request->get('applicationReasonCode');
        $this->description = $request->request->get('description');
        $this->attachments = $request->files;
    }

    public function getCommand(): CommandInterface
    {
        return new CreateCustomerRefundRequest(
            $this->orderId,
            $this->orderItemId,
            $this->applicationReasonCode,
            $this->description,
            $this->attachments
        );
    }
}
