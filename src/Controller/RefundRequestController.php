<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RefundPlugin\Entity\RefundRequestInterface;
use Sylius\RefundPlugin\Entity\RefundRequestMessageInterface;
use Sylius\RefundPlugin\Event\RefundRequestMessageEvent;
use Sylius\RefundPlugin\Form\Type\RefundRequestMessageType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RefundRequestController extends ResourceController
{
    public function addRefundRequestMessage(Request $request, string $orderId, string $refundRequestId): Response
    {
        /** @var RepositoryInterface $refundRequestRepository */
        $refundRequestRepository = $this->container->get('sylius_refund.repository.refund_request');

        /** @var RefundRequestInterface $refundRequest */
        $refundRequest = $refundRequestRepository->findOneBy(['id' => (int)$refundRequestId]);

        $router = $this->container->get('router');
        $mainEventDispatcher = $this->container->get('event_dispatcher');

        $form = $this->createForm(RefundRequestMessageType::class);
        $form->handleRequest($request);

        if (in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'], true)) {
            /** @var RefundRequestMessageInterface $refundRequestMessage */
            $refundRequestMessage = $form->getData();

            $refundRequest =$refundRequestRepository->findOneBy(['id' => $refundRequestId]);
            $refundRequest->addMessage($refundRequestMessage);

            $refundRequestMessageEvent = new RefundRequestMessageEvent($refundRequest);

            $mainEventDispatcher->dispatch($refundRequestMessageEvent, $refundRequestMessageEvent::NAME);

            $refundRequestRepository->add($refundRequest);

            return RedirectResponse::create($router->generate(
                'sylius_refund_admin_refund_request_show',
                [
                    'orderId' => $refundRequest->getOrder()->getId(),
                    'id' => $refundRequest->getId()
                ]
            ));
        }

        return $this->render('@SyliusRefundPlugin/Admin/RefundRequestMessage/refundRequestMessage.html.twig', [
            'form' => $form->createView(),
            'resource' => $refundRequest
        ]);
    }
}
