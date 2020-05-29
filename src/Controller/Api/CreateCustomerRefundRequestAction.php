<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Controller\Api;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\RefundPlugin\Request\Api\CreateCustomerRefundRequestRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CreateCustomerRefundRequestAction
{
    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var MessageBusInterface */
    private $bus;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(
        ViewHandlerInterface $viewHandler,
        MessageBusInterface $bus,
        ValidatorInterface $validator
    ) {
        $this->viewHandler = $viewHandler;
        $this->bus = $bus;
        $this->validator = $validator;
    }

    public function __invoke(Request $request): Response
    {
        $updateRequest = new CreateCustomerRefundRequestRequest($request);
        $validationResults = $this->validator->validate($updateRequest);

        if (0 !== count($validationResults)) {
            return $this->viewHandler->handle(
                View::create(null, Response::HTTP_BAD_REQUEST)
            );
        }

        $this->bus->dispatch($updateRequest->getCommand());
        return $this->viewHandler->handle(View::create(null, Response::HTTP_NO_CONTENT));
    }
}
