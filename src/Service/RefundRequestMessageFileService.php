<?php

declare(strict_types=1);

namespace Sylius\RefundPlugin\Service;

use Doctrine\Persistence\ObjectManager;
use Gaufrette\Filesystem;
use Sylius\RefundPlugin\Entity\RefundRequestMessageFile;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RefundRequestMessageFileService
{
    const
        FILE_PREFIX = 'notification_file'
    ;

    protected $objectManager;

    /** @var Filesystem */
    protected $filesystem;

    protected $filesystemName;

    public function __construct(ObjectManager $objectManager, Filesystem $filesystem, string $filesystemName)
    {
        $this->objectManager = $objectManager;
        $this->filesystem = $filesystem;

        $this->filesystemName = $filesystemName;
    }

    public function getFilesystem(): Filesystem
    {
        return $this->filesystem;
    }

    public function getFileAsResponse(string $hash)
    {
        $refundRequestMessageFileRepository = $this->objectManager->getRepository(RefundRequestMessageFile::class);

        if (!$fileInfo = $refundRequestMessageFileRepository->findOneBy(['hash' => $hash]))
        {
            throw new NotFoundHttpException('Brak pliku o podanym identyfikatorze.');
        }

        $filepath = $this->expandPath($fileInfo->getHash());

        if (!$this->filesystem->has($filepath))
        {
            throw new NotFoundHttpException('Brak pliku o podanym identyfikatorze.');
        }

        $response = new BinaryFileResponse('data://' . $this->filesystemName . '/' . $filepath);
        $response->headers->set('Content-Type', $fileInfo->getMimeType());
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $fileInfo->getFileName()
        );

        return $response;
    }

    public function expandPath(string $path): string
    {
        return sprintf(
            '%s/%s/%s/%s',
            self::FILE_PREFIX,
            substr($path, 0, 2),
            substr($path, 2, 2),
            substr($path, 4)
        );
    }

}
