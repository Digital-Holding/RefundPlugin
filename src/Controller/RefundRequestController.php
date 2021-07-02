<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Controller;

use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Exception\UpdateHandlingException;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\Resource\ResourceActions;
use Sylius\RefundPlugin\Entity\RefundRequestInterface;
use Sylius\RefundPlugin\Entity\RefundRequestMessageInterface;
use Sylius\RefundPlugin\Event\RefundRequestMessageEvent;
use Sylius\RefundPlugin\Form\Type\RefundRequestMessageType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class RefundRequestController extends ResourceController
{
    public function downloadRefundRequestMessageFile(Request $request): Response
    {
        $hash = $request->attributes->get('hash');
        $refundRequestMessageFileService = $this->get('sylius_refund_plugin.service.refund_request_message_file_service');

        $fileResponse = $refundRequestMessageFileService->getFileAsResponse($hash);

        return $fileResponse;
    }

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

            /** @var TokenStorageInterface $tokenStorage */
            $tokenStorage = $this->container->get('security.token_storage');

            $adminUser = $tokenStorage->getToken()->getUser();
            $refundRequestMessage->setAdminUser($adminUser);

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

    public function changeState(Request $request): Response
    {
        $router = $this->container->get('router');

        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::UPDATE);
        $resource = $this->findOr404($configuration);

        $form = $this->resourceFormFactory->create($configuration, $resource);
        $form->handleRequest($request);

        if (in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'], true) && $form->isSubmitted() && $form->isValid()) {
            $resource = $form->getData();

            try {
                $this->resourceUpdateHandler->handle($resource, $configuration, $this->manager);
            } catch (UpdateHandlingException $exception) {
                if (!$configuration->isHtmlRequest()) {
                    return $this->viewHandler->handle(
                        $configuration,
                        View::create($form, $exception->getApiResponseCode())
                    );
                }

                $this->flashHelper->addErrorFlash($configuration, $exception->getFlash());

                return $this->redirectHandler->redirectToReferer($configuration);
            }

            if ($configuration->isHtmlRequest()) {
                $this->flashHelper->addSuccessFlash($configuration, ResourceActions::UPDATE, $resource);
            }

            return $this->redirectHandler->redirectToResource($configuration, $resource);
        }

        if (!$configuration->isHtmlRequest()) {
            return $this->viewHandler->handle($configuration, View::create($form, Response::HTTP_BAD_REQUEST));
        }

        $this->applyStateMachineTransitionAction($request);
        $this->manager->flush();

        if ('accepted' === $resource->getState()){
            return new RedirectResponse($router->generate(
                'sylius_refund_order_refunds_list', ['orderNumber' => $resource->getOrder()->getNumber()]
            ));
        }

        return $this->redirectHandler->redirectToResource($configuration, $resource);
    }

    public function showOrderRefundRequests(string $orderId): Response
    {
        /** @var RepositoryInterface $orderRepostory */
        $orderRepostory = $this->container->get('sylius.repository.order');

        /** @var OrderInterface $order */
        $order = $orderRepostory->findOneBy(['id' => $orderId]);

        /** @var RepositoryInterface $refundRequestRepository */
        $refundRequestRepository = $this->container->get('sylius_refund.repository.refund_request');

        /** @var RefundRequestInterface $refundRequest */
        $refundRequestList = $refundRequestRepository->findByOrder($order);

        return $this->render('@SyliusRefundPlugin/Order/Admin/orderRefundRequestList.html.twig', [
            'order' => $order,
            'refundRequestList' => $refundRequestList
        ]);
    }
}
