<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Entity;

use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

interface ApplicationReasonInterface extends
    ResourceInterface,
    TranslatableInterface,
    CodeAwareInterface
{
    public const REFUND_TYPE = 'refund_type';

    public const RETURN_TYPE = 'return_type';

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getType(): ?string;

    public function setType(string $type): void;
}
