<?php

declare(strict_types = 1);

namespace Financial\Tests\Shared\Infrastructure\Mink;

use Symfony\Component\DomCrawler\Crawler;

final class MinkSessionRequestHelper
{
    private MinkHelper $sessionHelper;

    public function __construct($sessionHelper)
    {
        $this->sessionHelper = $sessionHelper;
    }

    public function sendRequest($method, $url, array $optionalParams = []): void
    {
        $this->request($method, $url, $optionalParams);
    }

    public function request($method, $url, array $optionalParams = []): Crawler
    {
        return $this->sessionHelper->sendRequest($method, $url, $optionalParams);
    }
}
