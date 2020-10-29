<?php

declare(strict_types=1);

namespace Tests\Sylius\RefundPlugin\Application\src\Entity;

trait VisibleAwareTrait
{
    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default" : 1}))
     */
    private $visible = true;

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): void
    {
        $this->visible = $visible;
    }
}
