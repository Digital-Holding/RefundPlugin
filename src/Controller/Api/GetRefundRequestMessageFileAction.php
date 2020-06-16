<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Controller\Api;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\RefundPlugin\Request\Api\CreateCustomerRefundRequestRequest;
use Sylius\RefundPlugin\Service\RefundRequestMessageFileService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class GetRefundRequestMessageFileAction
{
    private $refundRequestMessageFileService;

    public function __construct(RefundRequestMessageFileService $refundRequestMessageFileService)
    {
        $this->refundRequestMessageFileService = $refundRequestMessageFileService;
    }

    public function __invoke(Request $request)
    {
        $hash = $request->attributes->get('hash');
        $fileResponse = null;

        try {
            $fileResponse = $this->refundRequestMessageFileService->getFileAsResponse($hash);
        } catch (Exception $e) {
            return new JsonResponse([]);
        }

        return $fileResponse;
    }
}
