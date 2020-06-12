<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Controller\Api;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\RefundPlugin\Entity\RefundRequestInterface;
use Sylius\RefundPlugin\Entity\RefundRequestMessageInterface;
use Sylius\RefundPlugin\Factory\Api\RefundRequestMessageViewFactoryInterface;
use Sylius\RefundPlugin\Repository\RefundRequestRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final class ShowRefundRequestMessageListAction
{
    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var MessageBusInterface */
    private $bus;

    /** @var ValidatorInterface */
    private $validator;

    /** @var RefundRequestMessageViewFactoryInterface */
    private $refundRequestMessageViewFactory;

    /** @var RefundRequestRepositoryInterface */
    private $refundRequestRepository;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    public function __construct(
        ViewHandlerInterface $viewHandler,
        MessageBusInterface $bus,
        ValidatorInterface $validator,
        RefundRequestMessageViewFactoryInterface $refundRequestMessageViewFactory,
        RefundRequestRepositoryInterface $refundRequestRepository,
        TokenStorageInterface $tokenStorage
    ) {
        $this->viewHandler = $viewHandler;
        $this->bus = $bus;
        $this->validator = $validator;
        $this->refundRequestMessageViewFactory = $refundRequestMessageViewFactory;
        $this->refundRequestRepository = $refundRequestRepository;
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(Request $request): Response
    {
        /** @var ShopUserInterface $shopUser */
        $shopUser = $this->tokenStorage->getToken()->getUser();

        $id = $request->attributes->get('id');

        /** @var RefundRequestInterface $refundRequest */
        $refundRequest = $this->refundRequestRepository->findOneBy(['id' => $id]);
        Assert::notNull($refundRequest, 'Refund request for user has not been found.');

        $refundRequestMessageView = [];

        /** @var RefundRequestMessageInterface $refundRequestMessage */
        foreach ($refundRequest->getMessages() as $refundRequestMessage) {
            $refundRequestMessageView [] = $this->refundRequestMessageViewFactory->create($refundRequestMessage);
        }

        return $this->viewHandler->handle(View::create($refundRequestMessageView, Response::HTTP_OK));
    }
}
