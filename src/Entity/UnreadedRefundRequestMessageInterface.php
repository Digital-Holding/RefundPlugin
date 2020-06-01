<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Entity;

use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface UnreadedRefundRequestMessageInterface extends ResourceInterface
{
    public function getShopUser(): ShopUserInterface;

    public function setShopUser(ShopUserInterface $shopUser): void;

    public function getRefundRequestMessage(): RefundRequestMessageInterface;

    public function setRefundRequestMessage(RefundRequestMessageInterface $refundRequestMessage): void;
}
