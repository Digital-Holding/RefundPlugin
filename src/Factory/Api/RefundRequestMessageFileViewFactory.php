<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Factory\Api;

use Sylius\RefundPlugin\Entity\RefundRequestMessageFileInterface;
use Sylius\RefundPlugin\View\RefundRequest\RefundRequestMessageFileView;
use Symfony\Component\HttpFoundation\UrlHelper;

final class RefundRequestMessageFileViewFactory implements RefundRequestMessageFileViewFactoryInterface
{
    /** @var string */
    private $rootDir;

    /** @var UrlHelper */
    private $urlHelper;

    public function __construct(
        string $rootDir,
        UrlHelper $urlHelper
    )
    {
        $this->rootDir = $rootDir;
        $this->urlHelper = $urlHelper;
    }

    public function create(RefundRequestMessageFileInterface $refundRequestMessageFile): RefundRequestMessageFileView
    {
        /** @var RefundRequestMessageFileView $refundRequestMessageFileView */
        $refundRequestMessageFileView = new RefundRequestMessageFileView();

        $path = substr_replace($refundRequestMessageFile->getHash(), "/", 2,0);
        $path = substr_replace($path, "/", 5,0);

        $refundRequestMessageFileDir = $this->rootDir . '/var/uploads/sylius_refund/notification/file/' . $path;
        $messageFile = $this->urlHelper->getAbsoluteUrl($path);

        if (file_exists($refundRequestMessageFileDir) && null !== $messageFile) {

            $refundRequestMessageFileView->path = $messageFile;

            return $refundRequestMessageFileView;
        }

        $refundRequestMessageFileView->path = null;

        return $refundRequestMessageFileView;
    }
}
