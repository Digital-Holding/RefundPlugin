<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Controller\Api;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\RefundPlugin\Entity\ApplicationReasonInterface;
use Sylius\RefundPlugin\Factory\Api\ApplicationReasonViewFactoryInterface;
use Sylius\RefundPlugin\Repository\ApplicationReasonRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final class ShowApplicationReasonsByType
{
    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var MessageBusInterface */
    private $bus;

    /** @var ValidatorInterface */
    private $validator;

    /** @var ApplicationReasonRepositoryInterface */
    private $applicationReasonRepository;

    /** @var ApplicationReasonViewFactoryInterface */
    private $applicationReasonViewFactory;

    public function __construct(
        ViewHandlerInterface $viewHandler,
        MessageBusInterface $bus,
        ValidatorInterface $validator,
        ApplicationReasonRepositoryInterface $applicationReasonRepository,
        ApplicationReasonViewFactoryInterface $applicationReasonViewFactory
    ) {
        $this->viewHandler = $viewHandler;
        $this->bus = $bus;
        $this->validator = $validator;
        $this->applicationReasonRepository = $applicationReasonRepository;
        $this->applicationReasonViewFactory = $applicationReasonViewFactory;
    }

    public function __invoke(Request $request): Response
    {
        $type = $request->attributes->get('type');

        $applicationReasons = $this->applicationReasonRepository->findByType($type);
        Assert::notNull($applicationReasons, sprintf('Application Reason with type %s has not been found.', $type));

        $applicationReasonView = [];

        /** @var ApplicationReasonInterface $applicationReason */
        foreach ($applicationReasons as $applicationReason) {
            $applicationReasonView [] = $this->applicationReasonViewFactory->create($applicationReason);
        }

        return $this->viewHandler->handle(View::create($applicationReasonView, Response::HTTP_OK));
    }
}
