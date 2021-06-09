<?php

declare(strict_types = 1);

namespace Financial\Apps\Backoffice\Backend\Controller\DebtRejections;

use Financial\Unpaid\DebtRejections\Application\Create\DebtRejectionMultipleCreator;
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
    private DebtRejectionMultipleCreator $debtRejectionMultipleCreator;

    public function __construct(DebtRejectionMultipleCreator $debtRejectionMultipleCreator, Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->debtRejectionMultipleCreator = $debtRejectionMultipleCreator;
    }

    public function __invoke(Request $request): Response
    {
        /** @var UploadedFile $debtRejectionsFile */
        $debtRejectionsFile = $request->files->all()[0];
        $bankFileName = $debtRejectionsFile->getClientOriginalName();
        $targetFile = self::UNPAID_UPLOAD_DIRECTORY_PATH . $bankFileName;

        try {
            $this->filesystem->copy($debtRejectionsFile->getPathname(), $targetFile, true);
            $fileCopied = true;
        } catch (IOException $exception) {
            $fileCopied = $exception->getMessage();
        }

        if ($fileCopied) {
            $debtsRejectedFile = simplexml_load_file($targetFile);
            $this->debtRejectionMultipleCreator->__invoke($debtsRejectedFile, $bankFileName);
        }

        return new JsonResponse(
            [
                'file-name' => $bankFileName,
                'uploaded'  => $fileCopied
            ]
        );
    }
}
