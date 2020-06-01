<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\HttpFoundation\File\File;

interface RefundRequestMessageFileInterface extends ResourceInterface
{
    public function getCreatedAt(): ?\DateTime;

    public function getFileName(): ?string;

    public function setFileName(?string $fileName): self;

    public function getHash(): ?string;

    public function setHash(?string $hash): self;

    public function getFile(): ?File;

    public function setFile(?File $file): self;

    public function hasFile(): bool;

    public function getMimeType(): ?string;

    public function setMimeType(?string $mimeType): self;

    public function setCreatedAt(?\DateTime $createdAt): self;

    public function getRefundRequestMessage(): RefundRequestMessageInterface;

    public function setRefundRequestMessage(RefundRequestMessageInterface $refundRequestMessage): self;
}
