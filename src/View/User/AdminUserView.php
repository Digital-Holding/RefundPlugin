<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\View\User;

class AdminUserView
{
    /** @var int */
    public $id;

    /** @var string */
    public $username;

    /** @var string */
    public $usernameCanonical;

    /** @var array */
    public $roles;

    /** @var string */
    public $email;

    /** @var string */
    public $firstName;

    /** @var string */
    public $lastName;
}
