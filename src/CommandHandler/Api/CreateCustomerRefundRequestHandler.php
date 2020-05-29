<?php declare(strict_types=1);

namespace Sylius\RefundPlugin\CommandHandler\Api;

use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderItemUnitInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RefundPlugin\Command\Api\CreateCustomerRefundRequest;
use Sylius\RefundPlugin\Converter\LineItemsConverterInterface;
use Sylius\RefundPlugin\Entity\RefundRequestInterface;
use Sylius\RefundPlugin\Repository\ApplicationReasonRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Webmozart\Assert\Assert;

final class CreateCustomerRefundRequestHandler
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @var RepositoryInterface */
    private $orderItemUnitRepository;

    /** @var LineItemsConverterInterface */
    private $lineItemsConverter;

    /** @var FactoryInterface */
    private $refundRequestFactory;

    /** @var ApplicationReasonRepositoryInterface $applicationReasonRepository */
    private $applicationReasonRepository;

    /** @var ChannelContextInterface $channelContext */
    private $channelContext;

    /** @var RepositoryInterface */
    private $refundRequestRepository;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        TokenStorageInterface $tokenStorage,
        RepositoryInterface $orderItemUnitRepository,
        LineItemsConverterInterface $lineItemsConverter,
        FactoryInterface $refundRequestFactory,
        ApplicationReasonRepositoryInterface $applicationReasonRepository,
        ChannelContextInterface $channelContext,
        RepositoryInterface $refundRequestRepository
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->tokenStorage = $tokenStorage;
        $this->orderItemUnitRepository = $orderItemUnitRepository;
        $this->lineItemsConverter = $lineItemsConverter;
        $this->refundRequestFactory = $refundRequestFactory;
        $this->applicationReasonRepository = $applicationReasonRepository;
        $this->channelContext = $channelContext;
        $this->refundRequestRepository = $refundRequestRepository;
    }

    public function __invoke(CreateCustomerRefundRequest $command): void
    {
        /** @var ChannelInterface $channel */
        $channel = $this->channelContext->getChannel();

        /** @var ShopUserInterface $user */
        $user = $this->tokenStorage->getToken()->getUser();
        Assert::isInstanceOf($user, ShopUserInterface::class);

        /** @var OrderItemUnitInterface $orderItemUnit */
        $orderItemUnit = $this->orderItemUnitRepository->findOneBy(['id' => $command->orderItemUnitId()]);

        $orderItem = $orderItemUnit->getOrderItem();
        $order = $orderItem->getOrder();

        $applicationReason = $this->applicationReasonRepository->findOneBy(['code' => $command->applicationReasonCode()]);

        /** @var RefundRequestInterface $refundRequest */
        $refundRequest = $this->refundRequestFactory->createNew();

        $refundRequest->setApplicationReason($applicationReason);
        $refundRequest->setOrder($order);
        $refundRequest->setChannel($channel);

        $lineItem = $this->lineItemsConverter->convertUnit($orderItemUnit);
        $refundRequest->setLineItem($lineItem);

        $this->refundRequestRepository->add($refundRequest);
    }
}
