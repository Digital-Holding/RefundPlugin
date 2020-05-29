<?php declare(strict_types=1);

namespace Sylius\RefundPlugin\Command\Api;

class CreateCustomerRefundRequest implements CommandInterface
{
    /** @var integer */
    protected $orderId;

    /** @var integer */
    protected $orderItemUnitId;

    /** @var string */
    protected $applicationReasonCode;

    public function __construct(
        $orderId,
        $orderItemUnitId,
        string $applicationReasonCode
    ) {
        $this->orderId = $orderId;
        $this->orderItemUnitId = $orderItemUnitId;
        $this->applicationReasonCode = $applicationReasonCode;
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
    public function orderItemUnitId()
    {
        return $this->orderItemUnitId;
    }

    public function applicationReasonCode(): string
    {
        return $this->applicationReasonCode;
    }
}
