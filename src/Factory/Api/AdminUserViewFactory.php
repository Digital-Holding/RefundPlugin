<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory\Api;

use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\RefundPlugin\View\User\AdminUserView;

final class AdminUserViewFactory implements AdminUserViewFactoryInterface
{
    public function create(AdminUserInterface $adminUser): AdminUserView
    {
        /** @var AdminUserView $adminUserView */
        $adminUserView = new AdminUserView();

        $adminUserView->id = $adminUser->getId();
        $adminUserView->firstName = $adminUser->getFirstName();
        $adminUserView->lastName = $adminUser->getLastName();
        $adminUserView->email = $adminUser->getEmail();
        $adminUserView->roles = $adminUser->getRoles();
        $adminUserView->username = $adminUser->getUsername();
        $adminUserView->usernameCanonical = $adminUser->getUsernameCanonical();

        return $adminUserView;
    }
}
