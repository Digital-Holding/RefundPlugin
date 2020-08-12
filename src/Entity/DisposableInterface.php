<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Entity;

interface DisposableInterface
{
    public function isDisposable(): bool;

    public function setDisposable(bool $disposable): void;
}
