<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory;

use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\RefundPlugin\Entity\RefundRequestMessageFileInterface;
use Sylius\RefundPlugin\Entity\RefundRequestMessageInterface;

class RefundRequestMessageFileFactory implements RefundRequestMessageFileFactoryInterface
{
    /** @var FactoryInterface */
    private $factory;

    public function __construct(
        FactoryInterface $factory
    ) {
        $this->factory = $factory;
    }

    public function createNew(): RefundRequestMessageFileInterface
    {
        return $this->factory->createNew();
    }

    public function createForMessage(RefundRequestMessageInterface $refundRequestMessage): RefundRequestMessageFileInterface
    {
        /** @var RefundRequestMessageFileInterface $refundRequestMessageFile */
        $refundRequestMessageFile = $this->createNew();
        $refundRequestMessageFile->setRefundRequestMessage($refundRequestMessage);

        return $refundRequestMessageFile;
    }
}
