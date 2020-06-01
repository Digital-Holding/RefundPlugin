<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Entity;

use Sylius\Component\Core\Model\ShopUserInterface;

class UnreadedRefundRequestMessage implements UnreadedRefundRequestMessageInterface
{
    /** @var int */
    protected $id;

    /** @var ShopUserInterface */
    protected $shopUser;

    /** @var RefundRequestMessageInterface */
    protected $refundRequestMessage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShopUser(): ShopUserInterface
    {
        return $this->shopUser;
    }

    public function setShopUser(ShopUserInterface $shopUser): void
    {
        $this->shopUser = $shopUser;
    }

    public function getRefundRequestMessage(): RefundRequestMessageInterface
    {
        return $this->refundRequestMessage;
    }

    public function setRefundRequestMessage(RefundRequestMessageInterface $refundRequestMessage): void
    {
        $this->refundRequestMessage = $refundRequestMessage;
    }
}
