<?php

declare(strict_types = 1);

namespace Financial\Apps\Backoffice\Backend\Controller\DebtRejections;

use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class UploadDebtRejectionsPostController
{
    const UNPAID_UPLOAD_DIRECTORY_PATH = '/files/BANK/DirectDebit/IN/';

    private Filesystem $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function __invoke(Request $request): Response
    {
        /** @var UploadedFile $debtRejectionsFile */
        $debtRejectionsFile = $request->files->all()[0];
        $targetFile = self::UNPAID_UPLOAD_DIRECTORY_PATH . $debtRejectionsFile->getClientOriginalName();

        try {
            $this->filesystem->copy($debtRejectionsFile->getPathname(), $targetFile, true);
            $status = true;
        } catch (IOException $exception) {
            $status = $exception->getMessage();
        }

        return new JsonResponse(
            [
                'file-name' => $debtRejectionsFile->getClientOriginalName(),
                'uploaded'  => $status
            ]
        );
    }
}
