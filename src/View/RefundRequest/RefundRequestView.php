<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\View\RefundRequest;

class RefundRequestView
{
    /** @var mixed */
    public $id;

    /** @var string */
    public $applicationReasonType;

    /** @var string */
    public $applicationReason;

    /** @var string */
    public $orderNumber;

    /** @var string */
    public $state;

    /** @var string */
    public $productName;

    /** @var string */
    public $createdAt;

    /** @var string */
    public $tokenValue;

    /** @var array|RefundRequestMessageView[] */
    public $messages;

    /** @var string */
    public $variantCode;

    /** @var string */
    public $variantName;
}
