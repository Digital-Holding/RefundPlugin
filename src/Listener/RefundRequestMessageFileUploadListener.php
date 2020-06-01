<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Listener;

use Sylius\RefundPlugin\Entity\RefundRequestInterface;
use Sylius\RefundPlugin\Entity\RefundRequestMessageInterface;
use Sylius\RefundPlugin\Event\RefundRequestMessageEvent;
use Sylius\RefundPlugin\Uploader\RefundRequestMessageFileUploader;

final class RefundRequestMessageFileUploadListener
{
    /** @var RefundRequestMessageFileUploader */
    private $uploader;

    public function __construct(RefundRequestMessageFileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function uploadRefundRequestMessageFiles(RefundRequestMessageEvent $event): void
    {
        /** @var RefundRequestInterface $refundRquest */
        $refundRequest = $event->getRefundRequest();

        $refundRequestMessages = $refundRequest->getMessages();

        /** @var RefundRequestMessageInterface $refundRequestMessage */
        foreach ($refundRequestMessages as $refundRequestMessage) {
            if (!empty($refundRequestMessage->getRefundRequestMessageFiles())) {
                foreach ($refundRequestMessage->getRefundRequestMessageFiles() as $file) {
                    $this->uploader->upload($file);
                }
            }
        }
    }
}
