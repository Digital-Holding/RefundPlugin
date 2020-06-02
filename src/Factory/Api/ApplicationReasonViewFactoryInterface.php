<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory\Api;

use Sylius\RefundPlugin\Entity\ApplicationReasonInterface;
use Sylius\RefundPlugin\View\ApplicationReason\ApplicationReasonView;

interface ApplicationReasonViewFactoryInterface
{
    public function create(ApplicationReasonInterface $applicationReason): ApplicationReasonView;
}
