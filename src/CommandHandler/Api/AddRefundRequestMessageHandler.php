<?php declare(strict_types=1);

namespace Sylius\RefundPlugin\CommandHandler\Api;

use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RefundPlugin\Command\Api\AddRefundRequestMessage;
use Sylius\RefundPlugin\Entity\RefundRequestInterface;
use Sylius\RefundPlugin\Entity\RefundRequestMessageFileInterface;
use Sylius\RefundPlugin\Entity\RefundRequestMessageInterface;
use Sylius\RefundPlugin\Factory\RefundRequestMessageFileFactoryInterface;
use Sylius\RefundPlugin\Uploader\RefundRequestMessageFileUploaderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Webmozart\Assert\Assert;

final class AddRefundRequestMessageHandler
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var TokenStorageInterface */
    private $tokenStorage;

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

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        TokenStorageInterface $tokenStorage,
        RepositoryInterface $refundRequestRepository,
        FactoryInterface $refundRequestMessageFactory,
        RefundRequestMessageFileFactoryInterface $refundRequestMessageFileFactory,
        RefundRequestMessageFileUploaderInterface $refundRequestMessageFileUploader,
        RepositoryInterface $refundRequestMessageFileRepository
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->tokenStorage = $tokenStorage;
        $this->refundRequestRepository = $refundRequestRepository;
        $this->refundRequestMessageFactory = $refundRequestMessageFactory;
        $this->refundRequestMessageFileFactory = $refundRequestMessageFileFactory;
        $this->refundRequestMessageFileUploader = $refundRequestMessageFileUploader;
        $this->refundRequestMessageFileRepository = $refundRequestMessageFileRepository;
    }

    public function __invoke(AddRefundRequestMessage $command): void
    {
        /** @var ShopUserInterface $user */
        $user = $this->tokenStorage->getToken()->getUser();
        Assert::isInstanceOf($user, ShopUserInterface::class);

        /** @var RefundRequestInterface $refundRequest */
        $refundRequest = $this->refundRequestRepository->findOneBy(['id' => $command->refundRequestId()]);

        /** @var RefundRequestMessageInterface $refundRequestMessage */
        $refundRequestMessage = $this->refundRequestMessageFactory->createNew();
        $refundRequestMessage->setMessage($command->message());
        $refundRequestMessage->setShopUser($user);

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
