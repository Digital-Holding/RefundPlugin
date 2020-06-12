<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\View\RefundRequest;

class RefundRequestMessageView
{
    /** @var string */
    public $shopUser;

    /** @var string */
    public $adminUser;

    /** @var string */
    public $message;

    /** @var string */
    public $createdAt;

    /** @var RefundRequestMessageFileView[] */
    public $files = [];
}
