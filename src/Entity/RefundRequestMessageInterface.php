<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface RefundRequestMessageInterface extends ResourceInterface
{
    public function getShopUser(): ?ShopUserInterface;

    public function setShopUser(?ShopUserInterface $shopUser): void;

    public function getAdminUser(): ?AdminUserInterface;

    public function setAdminUser(?AdminUserInterface $adminUser): void;

    public function getMessage(): ?string;

    public function setMessage(?string $message): void;

    public function getDateTime(): ?\DateTime;

    public function setDateTime(?\DateTime $dateTime): void;

    public function getRefundRequest(): RefundRequestInterface;

    public function setRefundRequest(RefundRequestInterface $refundRequest): void;

    public function getRefundRequestMessageFiles(): ?Collection;

    public function hasRefundRequestMessageFile(RefundRequestMessageFileInterface $refundRequestMessageFile): bool;

    public function addRefundRequestMessageFile(RefundRequestMessageFileInterface $refundRequestMessageFile);

    public function removeRefundRequestMessageFile(RefundRequestMessageFileInterface $refundRequestMessageFile): void;

    public function getUnreadedRefundRequestMessages(): ?Collection;

    public function hasUnreadedRefundRequestMessage(UnreadedRefundRequestMessageInterface $unreadedRefundRequestMessage): bool;

    public function addUnreadedRefundRequestMessage(UnreadedRefundRequestMessageInterface $unreadedRefundRequestMessage);
}
