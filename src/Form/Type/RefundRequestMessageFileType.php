<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

final class RefundRequestMessageFileType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class);
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_refund_refund_request_message_file';
    }
}
