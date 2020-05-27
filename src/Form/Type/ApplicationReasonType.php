<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Sylius\RefundPlugin\Entity\ApplicationReason;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

final class ApplicationReasonType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->addEventSubscriber(new AddCodeFormSubscriber())
            ->add('type', ChoiceType::class, [
                'choices' => ApplicationReason::getAllTypes(),
                'choice_label' => function ($choice) {
                    $translated = 'sylius_refund.form.application_reason_type.' . $choice;
                    return ($translated);
                },
                'label' => 'sylius_refund.form.application_reason.type',
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'label' => false,
                'entry_type' => ApplicationReasonTranslationType::class,
            ])

        ;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_refund_application_reason';
    }
}
