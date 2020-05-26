<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

interface RefundTypeInterface extends ResourceInterface, TranslatableInterface
{
    public function getCode(): ?string;

    public function setCode(?string $code): void;

    public function getName(): ?string;

    public function setName(?string $name): void;
}
