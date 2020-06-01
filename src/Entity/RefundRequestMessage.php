<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Entity;

use Datetime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Core\Model\ShopUserInterface;

class RefundRequestMessage implements RefundRequestMessageInterface
{
    /** @var int */
    protected $id;

    /** @var ShopUserInterface */
    protected $shopUser;

    /** @var AdminUserInterface */
    protected $adminUser;

    /** @var string */
    protected $message;

    /** @var DateTime */
    protected $dateTime;

    /** @var RefundRequestInterface */
    protected $refundRequest;

    /** @var Collection|RefundRequestMessageFileInterface[] */
    protected $refundRequestMessageFiles;

    /** @var Collection|UnreadedRefundRequestMessageInterface[] */
    protected $unreadedRefundRequestMessages;

    public function __construct()
    {
        $this->dateTime = new \DateTime();
        $this->refundRequestMessageFiles = new ArrayCollection();
        $this->unreadedRefundRequestMessages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShopUser(): ?ShopUserInterface
    {
        return $this->shopUser;
    }

    public function setShopUser(?ShopUserInterface $shopUser): void
    {
        $this->shopUser = $shopUser;
    }

    public function getAdminUser(): ?AdminUserInterface
    {
        return $this->adminUser;
    }

    public function setAdminUser(?AdminUserInterface $adminUser): void
    {
        $this->adminUser = $adminUser;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    public function getDateTime(): ?DateTime
    {
        return $this->dateTime;
    }

    public function setDateTime(?DateTime $dateTime): void
    {
        $this->dateTime = $dateTime;
    }

    public function getRefundRequest(): RefundRequestInterface
    {
        return $this->refundRequest;
    }

    public function setRefundRequest(RefundRequestInterface $refundRequest): void
    {
        $this->refundRequest = $refundRequest;
    }

    public function getRefundRequestMessageFiles(): ?Collection
    {
        return $this->refundRequestMessageFiles;
    }

    public function hasRefundRequestMessageFile(RefundRequestMessageFileInterface $refundRequestMessageFile): bool
    {
        return $this->refundRequestMessageFiles->contains($refundRequestMessageFile);
    }

    public function addRefundRequestMessageFile(RefundRequestMessageFileInterface $refundRequestMessageFile)
    {
        if (!$this->hasRefundRequestMessageFile($refundRequestMessageFile)) {
            $refundRequestMessageFile->setRefundRequestMessage($this);
            $this->refundRequestMessageFiles->add($refundRequestMessageFile);
        }

        return $this;
    }

    public function removeRefundRequestMessageFile(RefundRequestMessageFileInterface $refundRequestMessageFile): void
    {
        if ($this->hasRefundRequestMessageFile($refundRequestMessageFile)) {
            $this->refundRequestMessageFiles->removeElement($refundRequestMessageFile);
            $refundRequestMessageFile->setRefundRequestMessage(null);
        }
    }

    public function getUnreadedRefundRequestMessages(): ?Collection
    {
        return $this->unreadedRefundRequestMessages;
    }

    public function hasUnreadedRefundRequestMessage(UnreadedRefundRequestMessageInterface $unreadedRefundRequestMessage): bool
    {
        return $this->unreadedRefundRequestMessages->contains($unreadedRefundRequestMessage);
    }

    public function addUnreadedRefundRequestMessage(UnreadedRefundRequestMessageInterface $unreadedRefundRequestMessage)
    {
        if (!$this->hasUnreadedRefundRequestMessage($unreadedRefundRequestMessage)) {
            $unreadedRefundRequestMessage->setRefundRequestMessage($this);
            $this->unreadedRefundRequestMessages->add($unreadedRefundRequestMessage);
        }

        return $this;
    }
}
