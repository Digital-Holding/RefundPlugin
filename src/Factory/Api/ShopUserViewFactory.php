<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory\Api;

use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\RefundPlugin\View\User\ShopUserView;

final class ShopUserViewFactory implements ShopUserViewFactoryInteface
{
    /** @var CustomerViewFactoryInterface */
    private $customerViewFactory;

    public function __construct(CustomerViewFactoryInterface $customerViewFactory)
    {
        $this->customerViewFactory = $customerViewFactory;
    }

    public function create(ShopUserInterface $shopUser): ShopUserView
    {
        /** @var ShopUserView $shopUserView */
        $shopUserView = new ShopUserView();

        $shopUserView->id = $shopUser->getId();
        $shopUserView->username = $shopUser->getUsername();
        $shopUserView->usernameCanonical = $shopUser->getUsernameCanonical();
        $shopUserView->roles = $shopUser->getRoles();
        $shopUserView->customer = $this->customerViewFactory->create($shopUser->getCustomer());

        return $shopUserView;
    }
}
