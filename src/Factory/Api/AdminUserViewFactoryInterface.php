<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory\Api;

use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\RefundPlugin\View\User\AdminUserView;

interface AdminUserViewFactoryInterface
{
    public function create(AdminUserInterface $adminUser): AdminUserView;
}
