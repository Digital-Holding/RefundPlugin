<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Entity;

use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class RefundType implements RefundTypeInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
        getTranslation as private doGetTranslation;
    }

    /** @var int|null */
    protected $id;

    /** @var string */
    protected $code;

    public function __construct()
    {
        $this->initializeTranslationsCollection();
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
     * @return TranslationInterface|RefundTypeTranslationInterface
     */
    public function getTranslation(?string $locale = null): TranslationInterface
    {
        /** @var RefundTypeTranslationInterface $translation */
        $translation = $this->doGetTranslation($locale);

        return $translation;
    }

    protected function createTranslation(): TranslationInterface
    {
        return new RefundTypeTranslation();
    }
}
