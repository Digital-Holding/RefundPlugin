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
use Sylius\Component\Product\Generator\SlugGeneratorInterface;
use Sylius\Component\Product\Resolver\ProductVariantResolverInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

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

    public function __construct(
        ProductFactoryInterface $productFactory,
        ChannelContextInterface $channelContext,
        ProductRepositoryInterface $productRepository,
        SlugGeneratorInterface $slugGenerator,
        ProductVariantResolverInterface $defaultVariantResolver,
        FactoryInterface $channelPricingFactory
    )
    {
        $this->productFactory = $productFactory;
        $this->channelContext = $channelContext;
        $this->productRepository = $productRepository;
        $this->slugGenerator = $slugGenerator;
        $this->defaultVariantResolver = $defaultVariantResolver;
        $this->channelPricingFactory = $channelPricingFactory;
    }

    public function createProductWithVariant(string $productName, int $price, string $unitCode): ProductVariantInterface
    {
        $channel = $this->channelContext->getChannel();

        /** @var ProductInterface $product */
        $product = $this->productFactory->createWithVariant();

        $product->setCode('refund_' . $unitCode);
        $product->setName($productName);
        $product->setSlug($this->slugGenerator->generate($productName));

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

        $productVariant->setCode($product->getCode());
        $productVariant->setName($product->getName());

        $this->productRepository->add($product);

        return $productVariant;
    }

    public function createVariantForProduct(ProductInterface $product): ProductVariantInterface
    {
        $channel = $this->channelContext->getChannel();

        /** @var ProductVariantInterface $productVariant */
        $productVariant = $this->defaultVariantResolver->getVariant($product);

        if (null !== $channel) {
            $productVariant->addChannelPricing($this->createChannelPricingForChannel(0, $channel));
        }

        $productVariant->setCode($product->getCode());
        $productVariant->setName($product->getName());

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
