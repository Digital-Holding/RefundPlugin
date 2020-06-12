<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Request\Api;

use Sylius\RefundPlugin\Command\Api\AddRefundRequestMessage;
use Sylius\RefundPlugin\Command\Api\CommandInterface;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;

class AddRefundRequestMessageRequest
{
    /** @var mixed */
    protected $refundRequestId;

    /** @var string */
    protected $message;

    /** @var FileBag|null */
    protected $attachments;

    public function __construct(
        Request $request
    ) {
        $this->refundRequestId = $request->attributes->get('id');
        $this->message = $request->request->get('message');
        $this->attachments = $request->files;
    }

    public function getCommand(): CommandInterface
    {
        return new AddRefundRequestMessage(
            $this->refundRequestId,
            $this->message,
            $this->attachments
        );
    }
}
