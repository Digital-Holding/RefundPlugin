<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMainMenuListener
{
    public function addCreditMemosSection(MenuBuilderEvent $event): void
    {
        /** @var ItemInterface $salesMenu */
        $salesMenu = $event->getMenu()->getChild('sales');

        /** @var ItemInterface $configurationMenu */
        $configurationMenu = $event->getMenu()->getChild('configuration');

        $salesMenu
            ->addChild('credit_memos', [
                'route' => 'sylius_refund_admin_credit_memo_index',
            ])
            ->setLabel('sylius_refund.ui.credit_memos')
            ->setLabelAttribute('icon', 'inbox')
        ;

        $salesMenu
            ->addChild('refund_requests', [
                'route' => 'sylius_refund_admin_refund_request_index',
            ])
            ->setLabel('sylius_refund.ui.refund_requests')
            ->setLabelAttribute('icon', 'handshake')
        ;

        $configurationMenu
            ->addChild('application_reason', [
                'route' => 'sylius_refund_admin_application_reason_index',
            ])
            ->setLabel('sylius_refund.ui.application_reasons')
            ->setLabelAttribute('icon', 'wpforms')
        ;

    }
}
