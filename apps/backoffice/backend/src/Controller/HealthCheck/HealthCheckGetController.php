<?php

declare(strict_types = 1);

namespace Financial\Apps\Backoffice\Backend\Controller\HealthCheck;

use Financial\Shared\Domain\RandomNumberGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HealthCheckGetController
{
    private RandomNumberGenerator $generator;

    public function __construct(RandomNumberGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function __invoke(Request $request): Response
    {
        return new JsonResponse(
            [
                'backoffice-backend' => 'ok',
                'rand'               => $this->generator->generate(),
            ]
        );
    }
}
