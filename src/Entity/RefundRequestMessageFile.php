<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Entity;

use Datetime;
use Symfony\Component\HttpFoundation\File\File;

class RefundRequestMessageFile implements RefundRequestMessageFileInterface
{
    /** @var int */
    private $id;

    /** @var string */
    protected $hash;

    /** @var File */
    protected $file;

    /** @var string */
    protected $fileName;

    /** @var string */
    protected $mimeType;

    /** @var string */
    protected $originalPath;

    /** @var DateTime */
    protected $createdAt;

    /** @var RefundRequestMessageInterface */
    protected $refundRequestMessage;

    public function __construct()
    {
        $this->createdAt = new Datetime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): RefundRequestMessageFileInterface
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(?string $hash): RefundRequestMessageFileInterface
    {
        $this->hash = $hash;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): RefundRequestMessageFileInterface
    {
        $this->file = $file;

        return $this;
    }

    public function hasFile(): bool
    {
        return null !== $this->file;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): RefundRequestMessageFileInterface
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function setCreatedAt(?DateTime $createdAt): RefundRequestMessageFileInterface
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getRefundRequestMessage(): RefundRequestMessageInterface
    {
        return $this->refundRequestMessage;
    }

    public function setRefundRequestMessage(RefundRequestMessageInterface $refundRequestMessage): RefundRequestMessageFileInterface
    {
        $this->refundRequestMessage = $refundRequestMessage;

        return $this;
    }
}
