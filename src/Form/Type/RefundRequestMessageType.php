<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class RefundRequestMessageType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', TextType::class, [
                'label' => false,
            ])
            ->add('refundRequestMessageFiles', CollectionType::class, [
                'entry_type' => RefundRequestMessageFileType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => true,
                'label' => 'sylius_refund.form.refund_request_message.message_files',
                'mapped' => true
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_refund_refund_request_message';
    }
}
