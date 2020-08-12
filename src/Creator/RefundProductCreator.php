<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Creator;

use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Product\Factory\ProductFactoryInterface;
use Sylius\Component\Product\Factory\ProductVariantFactoryInterface;
use Sylius\Component\Product\Generator\SlugGeneratorInterface;
use Sylius\Component\Product\Resolver\ProductVariantResolverInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\RefundPlugin\Assigner\RefundAssigner;
use Sylius\RefundPlugin\Entity\LineItemInterface;

final class RefundProductCreator implements RefundProductCreatorInterface
{
    /** @var ProductFactoryInterface */
    private $productFactory;

    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var SlugGeneratorInterface */
    private $slugGenerator;

    /** @var ProductVariantResolverInterface */
    private $defaultVariantResolver;

    /** @var FactoryInterface */
    private $channelPricingFactory;

    /** @var ProductVariantFactoryInterface */
    private $productVariantFactory;

    public function __construct(
        ProductFactoryInterface $productFactory,
        ChannelContextInterface $channelContext,
        ProductRepositoryInterface $productRepository,
        SlugGeneratorInterface $slugGenerator,
        ProductVariantResolverInterface $defaultVariantResolver,
        FactoryInterface $channelPricingFactory,
        ProductVariantFactoryInterface $productVariantFactory
    )
    {
        $this->productFactory = $productFactory;
        $this->channelContext = $channelContext;
        $this->productRepository = $productRepository;
        $this->slugGenerator = $slugGenerator;
        $this->defaultVariantResolver = $defaultVariantResolver;
        $this->channelPricingFactory = $channelPricingFactory;
        $this->productVariantFactory = $productVariantFactory;
    }

    public function createProductWithVariant(string $productName, int $price, string $unitCode): ProductVariantInterface
    {
        $channel = $this->channelContext->getChannel();

        /** @var ProductInterface $product */
        $product = $this->productFactory->createWithVariant();

        $product->setCode(RefundAssigner::REFUND_PRODUCT_CODE);
        $product->setName($productName);
        $product->setSlug($this->slugGenerator->generate($productName));
        $product->setDisposable(true);

        if (null !== $channel) {
            $product->addChannel($channel);

            foreach ($channel->getLocales() as $locale) {
                $product->setFallbackLocale($locale->getCode());
                $product->setCurrentLocale($locale->getCode());

                $product->setName($productName);
                $product->setSlug($this->slugGenerator->generate($productName));
            }
        }

        /** @var ProductVariantInterface $productVariant */
        $productVariant = $this->defaultVariantResolver->getVariant($product);

        if (null !== $channel) {
            $productVariant->addChannelPricing($this->createChannelPricingForChannel($price, $channel));
        }

        $variantCode = $product->getCode() . '_' . $unitCode;

        $productVariant->setCode($variantCode);
        $productVariant->setName($product->getName());

        $this->productRepository->add($product);

        return $productVariant;
    }

    public function createVariantForProduct(LineItemInterface $lineItem, ProductInterface $product): ProductVariantInterface
    {
        $channel = $this->channelContext->getChannel();

        /** @var ProductVariantInterface $productVariant */
        $productVariant = $this->productVariantFactory->createNew();

        if (null !== $channel) {
            $productVariant->addChannelPricing($this->createChannelPricingForChannel(0, $channel));
        }

        $variantCode = $product->getCode() . '_' . $lineItem->variantCode();

        $productVariant->setCode($variantCode);
        $productVariant->setName($product->getName());
        $productVariant->setProduct($product);

        $product->addVariant($productVariant);

        $this->productRepository->add($product);

        return $productVariant;
    }

    /**
     * @return ChannelPricingInterface
     */
    private function createChannelPricingForChannel(int $price, ChannelInterface $channel = null)
    {
        /** @var ChannelPricingInterface $channelPricing */
        $channelPricing = $this->channelPricingFactory->createNew();
        $channelPricing->setPrice($price);
        $channelPricing->setChannelCode($channel->getCode());

        return $channelPricing;
    }
}
