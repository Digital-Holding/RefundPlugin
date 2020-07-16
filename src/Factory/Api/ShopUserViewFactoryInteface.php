<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory\Api;

use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\RefundPlugin\View\User\ShopUserView;

interface ShopUserViewFactoryInteface
{
    public function create(ShopUserInterface $shopUser): ShopUserView;
}
