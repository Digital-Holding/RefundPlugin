<?php declare(strict_types=1);

namespace Sylius\RefundPlugin\Command\Api;

use Symfony\Component\HttpFoundation\FileBag;

class CreateCustomerRefundRequest implements CommandInterface
{
    /** @var integer */
    protected $orderId;

    /** @var integer */
    protected $orderItemId;

    /** @var string */
    protected $applicationReasonCode;

    /** @var string */
    protected $description;

    /** @var FileBag|null */
    protected $attachments;

    public function __construct(
        $orderId,
        $orderItemId,
        string $applicationReasonCode,
        string $description,
        ?FileBag $attachments = null
    ) {
        $this->orderId = $orderId;
        $this->orderItemId = $orderItemId;
        $this->applicationReasonCode = $applicationReasonCode;
        $this->description = $description;
        $this->attachments = $attachments;
    }

    /**
     * @return int|string
     */
    public function orderId()
    {
        return $this->orderId;
    }

    /**
     * @return int|string
     */
    public function orderItemId()
    {
        return $this->orderItemId;
    }

    public function applicationReasonCode(): string
    {
        return $this->applicationReasonCode;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function attachments(): ?FileBag
    {
        return $this->attachments;
    }
}
