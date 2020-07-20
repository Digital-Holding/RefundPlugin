<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Assigner;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\RefundPlugin\Creator\RefundProductCreatorInterface;
use Sylius\RefundPlugin\Entity\RefundRequestInterface;
use Webmozart\Assert\Assert;

final class RefundAssigner implements RefundRequestAssignerInterface
{
    public const REFUND_PRODUCT_CODE = 'refund';

    /** @var RefundProductCreatorInterface */
    private $refundProductCreator;

    /** @var ProductVariantRepositoryInterface */
    private $productVariantRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var FactoryInterface */
    private $orderItemFactory;

    /** @var OrderItemQuantityModifierInterface */
    private $orderItemQuantityModifier;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    public function __construct(
        RefundProductCreatorInterface $refundProductCreator,
        ProductVariantRepositoryInterface $productVariantRepository,
        ProductRepositoryInterface $productRepository,
        FactoryInterface $orderItemFactory,
        OrderItemQuantityModifierInterface $orderItemQuantityModifier,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->refundProductCreator = $refundProductCreator;
        $this->productVariantRepository = $productVariantRepository;
        $this->productRepository = $productRepository;
        $this->orderItemFactory = $orderItemFactory;
        $this->orderItemQuantityModifier = $orderItemQuantityModifier;
        $this->orderRepository = $orderRepository;
    }

    public function assignRefundProductToOrder(RefundRequestInterface $refundRequest): void
    {
        $lineItem = $refundRequest->getLineItem();

        /** @var OrderInterface $order */
        $order = $refundRequest->getOrder();

        $variant = $this->productVariantRepository->findOneBy(['code' => $lineItem->variantCode()]);
        Assert::notNull($variant);

        /** @var ProductInterface $refundProduct */
        $refundProduct = $this->productRepository->findOneBy(['code' => RefundAssigner::REFUND_PRODUCT_CODE]);
        $refundProductVariant = $this->refundProductCreator->createVariantForProduct($refundProduct);

        if (null === $refundProduct) {
           $refundProductVariant = $this->refundProductCreator->createProductWithVariant('Refund', 0, $lineItem->variantCode());
        }

        /** @var OrderItemInterface $orderItem */
        $orderItem = $this->orderItemFactory->createNew();
        $orderItem->setVariant($refundProductVariant);

        $this->orderItemQuantityModifier->modify($orderItem, 1);

        $order->addItem($orderItem);
        $this->orderRepository->add($order);
    }
}
