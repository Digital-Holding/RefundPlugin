<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;

trait DisposableTrait
{
    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":0}))
     */
    protected $disposable = false;

    public function isDisposable(): bool
    {
        return $this->disposable;
    }

    public function setDisposable(bool $disposable): void
    {
        $this->disposable = $disposable;
    }
}
