<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class ApplicationReason implements ApplicationReasonInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
        getTranslation as private doGetTranslation;
    }

    /** @var int|null */
    protected $id;

    /** @var string */
    protected $code;

    /** @var string */
    protected $type;

    /** @var Collection|RefundRequestInterface[] */
    protected $refundRequests;

    public function __construct()
    {
        $this->initializeTranslationsCollection();
        $this->refundRequests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getName(): ?string
    {
        return $this->getTranslation()->getName();
    }

    public function setName(?string $name): void
    {
        $this->getTranslation()->setName($name);
    }

    /**
     * @return TranslationInterface|ApplicationReasonTranslationInterface
     */
    public function getTranslation(?string $locale = null): TranslationInterface
    {
        /** @var ApplicationReasonTranslationInterface $translation */
        $translation = $this->doGetTranslation($locale);

        return $translation;
    }

    protected function createTranslation(): TranslationInterface
    {
        return new ApplicationReasonTranslation();
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public static function getAllTypes(): array
    {
        return [
            ApplicationReasonInterface::REFUND_TYPE,
            ApplicationReasonInterface::RETURN_TYPE
        ];
    }

    public function getRefundRequests(): Collection
    {
        return $this->refundRequests;
    }
}
