<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory\Api;

use Sylius\RefundPlugin\Entity\ApplicationReasonInterface;
use Sylius\RefundPlugin\View\ApplicationReason\ApplicationReasonView;

final class ApplicationReasonViewFactory implements ApplicationReasonViewFactoryInterface
{
    public function create(ApplicationReasonInterface $applicationReason): ApplicationReasonView
    {
        /** @var ApplicationReasonView $applicationReasonView */
        $applicationReasonView = new ApplicationReasonView();

        $applicationReasonView->code = $applicationReason->getCode();
        $applicationReasonView->name = $applicationReason->getName();

        return $applicationReasonView;
    }
}
