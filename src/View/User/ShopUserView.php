<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\View\User;

class ShopUserView
{
    /** @var int */
    public $id;

    /** @var string */
    public $username;

    /** @var string */
    public $usernameCanonical;

    /** @var array */
    public $roles;

    /** @var CustomerView */
    public $customer;
}
