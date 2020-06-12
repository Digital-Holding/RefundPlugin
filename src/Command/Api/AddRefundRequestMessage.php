<?php declare(strict_types=1);

namespace Sylius\RefundPlugin\Command\Api;

use Symfony\Component\HttpFoundation\FileBag;

class AddRefundRequestMessage implements CommandInterface
{
    /** @var integer */
    protected $refundRequestId;

    /** @var string */
    protected $message;

    /** @var FileBag|null */
    protected $attachments;

    public function __construct(
        $refundRequestId,
        string $message,
        ?FileBag $attachments = null
    ) {
        $this->refundRequestId = $refundRequestId;
        $this->message = $message;
        $this->attachments = $attachments;
    }

    /**
     * @return int|string
     */
    public function refundRequestId()
    {
        return $this->refundRequestId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function attachments(): ?FileBag
    {
        return $this->attachments;
    }
}
