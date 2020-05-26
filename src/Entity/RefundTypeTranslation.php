<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Entity;

use Sylius\Component\Resource\Model\AbstractTranslation;

class RefundTypeTranslation extends AbstractTranslation implements RefundTypeTranslationInterface
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
