<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Uploader;

use Sylius\RefundPlugin\Entity\RefundRequestMessageFileInterface;
use Sylius\RefundPlugin\Service\RefundRequestMessageFileService;
use Symfony\Component\HttpFoundation\File\File;
use Webmozart\Assert\Assert;

final class RefundRequestMessageFileUploader
{
    private $refundRequestMessageFileService;

    public function __construct(RefundRequestMessageFileService $refundRequestMessageFileService)
    {
        $this->refundRequestMessageFileService = $refundRequestMessageFileService;
    }

    public function upload(RefundRequestMessageFileInterface $refundRequestMessageFile): void
    {
        if (!$refundRequestMessageFile->hasFile()) {
            return;
        }

        $file = $refundRequestMessageFile->getFile();

        $filesystem = $this->refundRequestMessageFileService->getFilesystem();

        /** @var File $file */
        Assert::isInstanceOf($file, File::class);

        do {
            $hash = bin2hex(random_bytes(16));
            $path = $this->refundRequestMessageFileService->expandPath($hash);
        } while ($filesystem->has($path));

        $refundRequestMessageFile->setMimeType($file->getMimeType())
            ->setFileName($file->getClientOriginalName())
            ->setHash($hash)
        ;

        $filesystem->write(
            $path,
            file_get_contents($refundRequestMessageFile->getFile()->getPathname())
        );
    }

}
