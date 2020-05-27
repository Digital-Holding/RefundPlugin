<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Entity;

use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderInterface;

class RefundRequest implements RefundRequestInterface
{
    /** @var int|null */
    protected $id;

    /** @var OrderInterface */
    protected $order;

    /** @var ChannelInterface */
    protected $channel;

    /** @var LineItemInterface */
    protected $lineItem;

    /** @var ApplicationReasonInterface */
    protected $applicationReason;

    /** @var string */
    protected $state = RefundRequestInterface::STATE_NEW;

    /** @var \DateTimeImmutable */
    protected $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): OrderInterface
    {
        return $this->order;
    }

    public function setOrder(OrderInterface $order): void
    {
        $this->order = $order;
    }

    public function getChannel(): ChannelInterface
    {
        return $this->channel;
    }

    public function setChannel(?ChannelInterface $channel): void
    {
        $this->channel = $channel;
    }

    public function getLineItem(): LineItemInterface
    {
        return $this->lineItem;
    }

    public function setLineItem(LineItemInterface $lineItem): void
    {
        $this->lineItem = $lineItem;
    }

    public function getApplicationReason(): ApplicationReasonInterface
    {
        return $this->applicationReason;
    }

    public function setApplicationReason(ApplicationReasonInterface $applicationReason): void
    {
        $this->applicationReason = $applicationReason;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
