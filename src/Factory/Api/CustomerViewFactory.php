<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory\Api;

use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\RefundPlugin\View\User\CustomerView;

final class CustomerViewFactory implements CustomerViewFactoryInterface
{
    public function create(CustomerInterface $customer): CustomerView
    {
        /** @var CustomerView $customerView */
        $customerView = new CustomerView();

        $customerView->id = $customer->getId();
        $customerView->firstName = $customer->getFirstName();
        $customerView->lastName = $customer->getLastName();
        $customerView->email = $customer->getEmail();
        $customerView->birthday = $customer->getBirthday();
        $customerView->gender = $customer->getGender();
        $customerView->phoneNumber = $customer->getPhoneNumber();
        $customerView->subscribedToNewsletter = $customer->isSubscribedToNewsletter();

        return $customerView;
    }
}
