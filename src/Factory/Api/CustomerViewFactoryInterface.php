<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory\Api;

use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\RefundPlugin\View\User\CustomerView;

interface CustomerViewFactoryInterface
{
    public function create(CustomerInterface $customer): CustomerView;
}
