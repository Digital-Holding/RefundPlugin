<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Controller\Api;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\RefundPlugin\Entity\RefundRequestInterface;
use Sylius\RefundPlugin\Factory\Api\RefundRequestViewFactoryInterface;
use Sylius\RefundPlugin\Repository\RefundRequestRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final class ShowShopUserRefundRequestById
{
    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var MessageBusInterface */
    private $bus;

    /** @var ValidatorInterface */
    private $validator;

    /** @var RefundRequestViewFactoryInterface */
    private $refundRequestViewFactory;

    /** @var RefundRequestRepositoryInterface */
    private $refundRequestRepository;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    public function __construct(
        ViewHandlerInterface $viewHandler,
        MessageBusInterface $bus,
        ValidatorInterface $validator,
        RefundRequestViewFactoryInterface $refundRequestViewFactory,
        RefundRequestRepositoryInterface $refundRequestRepository,
        TokenStorageInterface $tokenStorage
    )
    {
        $this->viewHandler = $viewHandler;
        $this->bus = $bus;
        $this->validator = $validator;
        $this->refundRequestViewFactory = $refundRequestViewFactory;
        $this->refundRequestRepository = $refundRequestRepository;
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(Request $request): Response
    {
        $id = $request->attributes->get('id');

        /** @var ShopUserInterface $shopUser */
        $shopUser = $this->tokenStorage->getToken()->getUser();

        /** @var RefundRequestInterface $refundRequest */
        $refundRequest = $this->refundRequestRepository->findOneBy(['id' => $id]);
        Assert::notNull($refundRequest, 'Refund request for user has not been found.');

        Assert::same($shopUser->getId(), $refundRequest->getShopUser()->getId());

        $refundRequestView [] = $this->refundRequestViewFactory->createWithMessages($refundRequest);

        return $this->viewHandler->handle(View::create($refundRequestView, Response::HTTP_OK));
    }
}
