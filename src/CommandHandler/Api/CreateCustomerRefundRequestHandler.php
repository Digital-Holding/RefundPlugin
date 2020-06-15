<?php declare(strict_types=1);

namespace Sylius\RefundPlugin\CommandHandler\Api;

use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\OrderItemUnitInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RefundPlugin\Command\Api\CreateCustomerRefundRequest;
use Sylius\RefundPlugin\Converter\LineItemsConverterInterface;
use Sylius\RefundPlugin\Entity\RefundRequestInterface;
use Sylius\RefundPlugin\Entity\RefundRequestMessageFileInterface;
use Sylius\RefundPlugin\Entity\RefundRequestMessageInterface;
use Sylius\RefundPlugin\Factory\RefundRequestMessageFileFactoryInterface;
use Sylius\RefundPlugin\Model\RefundType;
use Sylius\RefundPlugin\Provider\RemainingTotalProviderInterface;
use Sylius\RefundPlugin\Repository\ApplicationReasonRepositoryInterface;
use Sylius\RefundPlugin\Uploader\RefundRequestMessageFileUploaderInterface;
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
    private $orderItemRepository;

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

    /** @var FactoryInterface */
    private $refundRequestMessageFactory;

    /** @var RefundRequestMessageFileFactoryInterface */
    private $refundRequestMessageFileFactory;

    /** @var RefundRequestMessageFileUploaderInterface */
    private $refundRequestMessageFileUploader;

    /** @var RepositoryInterface */
    private $refundRequestMessageFileRepository;

    /** @var RemainingTotalProviderInterface */
    private $remainingTotalProvider;

    /** @var RepositoryInterface */
    private $lineItemRepository;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        TokenStorageInterface $tokenStorage,
        RepositoryInterface $orderItemRepository,
        LineItemsConverterInterface $lineItemsConverter,
        FactoryInterface $refundRequestFactory,
        ApplicationReasonRepositoryInterface $applicationReasonRepository,
        ChannelContextInterface $channelContext,
        RepositoryInterface $refundRequestRepository,
        FactoryInterface $refundRequestMessageFactory,
        RefundRequestMessageFileFactoryInterface $refundRequestMessageFileFactory,
        RefundRequestMessageFileUploaderInterface $refundRequestMessageFileUploader,
        RepositoryInterface $refundRequestMessageFileRepository,
        RemainingTotalProviderInterface $remainingTotalProvider,
        RepositoryInterface $lineItemRepository
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->tokenStorage = $tokenStorage;
        $this->orderItemRepository = $orderItemRepository;
        $this->lineItemsConverter = $lineItemsConverter;
        $this->refundRequestFactory = $refundRequestFactory;
        $this->applicationReasonRepository = $applicationReasonRepository;
        $this->channelContext = $channelContext;
        $this->refundRequestRepository = $refundRequestRepository;
        $this->refundRequestMessageFactory = $refundRequestMessageFactory;
        $this->refundRequestMessageFileFactory = $refundRequestMessageFileFactory;
        $this->refundRequestMessageFileUploader = $refundRequestMessageFileUploader;
        $this->refundRequestMessageFileRepository = $refundRequestMessageFileRepository;
        $this->remainingTotalProvider = $remainingTotalProvider;
        $this->lineItemRepository = $lineItemRepository;
    }

    public function __invoke(CreateCustomerRefundRequest $command): void
    {
        /** @var ChannelInterface $channel */
        $channel = $this->channelContext->getChannel();

        /** @var ShopUserInterface $user */
        $user = $this->tokenStorage->getToken()->getUser();
        Assert::isInstanceOf($user, ShopUserInterface::class);

        /** @var OrderItemInterface $orderItem */
        $orderItem = $this->orderItemRepository->findOneBy(['id' => $command->orderItemId()]);

        $order = $orderItem->getOrder();

        $applicationReason = $this->applicationReasonRepository->findOneBy(['code' => $command->applicationReasonCode()]);

        /** @var RefundRequestMessageInterface $refundRequestMessage */
        $refundRequestMessage = $this->refundRequestMessageFactory->createNew();
        $refundRequestMessage->setMessage($command->getDescription());
        $refundRequestMessage->setShopUser($user);

        /** @var RefundRequestInterface $refundRequest */
        $refundRequest = $this->refundRequestFactory->createNew();

        foreach ($orderItem->getUnits() as $itemUnit) {
            if($this->remainingTotalProvider->getTotalLeftToRefund($itemUnit->getId(), RefundType::orderItemUnit()) > 0) {
                $lineItem = $this->lineItemsConverter->convertUnit($itemUnit);

                $refundRequest->setLineItem($lineItem);
                $this->lineItemRepository->add($lineItem);
                break;
            }
        }

        $refundRequest->setApplicationReason($applicationReason);
        $refundRequest->setOrder($order);
        $refundRequest->setChannel($channel);
        $refundRequest->setShopUser($user);
        $refundRequest->addMessage($refundRequestMessage);

        if (null !== $command->attachments()) {
            foreach ($command->attachments() as $attachment) {
                /** @var RefundRequestMessageFileInterface $messageFile */
                $messageFile = $this->refundRequestMessageFileFactory->createNew();
                $messageFile->setFile($attachment);
                $refundRequestMessage->addRefundRequestMessageFile($messageFile);

                $this->refundRequestMessageFileUploader->upload($messageFile);
                $this->refundRequestMessageFileRepository->add($messageFile);
            }
        }


        $this->refundRequestRepository->add($refundRequest);
    }
}
