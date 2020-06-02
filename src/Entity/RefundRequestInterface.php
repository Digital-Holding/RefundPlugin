<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Channel\Model\ChannelAwareInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface RefundRequestInterface extends ResourceInterface, ChannelAwareInterface
{
    public const STATE_NEW = 'new';

    public const STATE_PENDING_ITEM_RETURN = 'pending_item_return';

    public const STATE_PACKAGE_RECEIVED = 'package_received';

    public const STATE_ACCEPTED = 'accepted';

    public const STATE_CANCELLED = 'cancelled';

    public const STATE_COMPLETED = 'completed';

    public function getOrder(): OrderInterface;

    public function setOrder(OrderInterface $order): void;

    public function getLineItem(): LineItemInterface;

    public function setLineItem(LineItemInterface $lineItem): void;

    public function getApplicationReason(): ApplicationReasonInterface;

    public function setApplicationReason(ApplicationReasonInterface $applicationReason): void;

    public function getState(): string;

    public function setState(string $state): void;

    public function getCreatedAt(): \DateTime;

    public function setCreatedAt(\DateTime $createdAt): void;

    public function getMessages(): Collection;

    public function hasMessage(RefundRequestMessageInterface $message): bool;

    public function addMessage(RefundRequestMessageInterface $message): void;

    public function removeOrderNote(RefundRequestMessageInterface $message): void;

    public function getShopUser(): ?ShopUserInterface;

    public function setShopUser(?ShopUserInterface $shopUser): void;
}
