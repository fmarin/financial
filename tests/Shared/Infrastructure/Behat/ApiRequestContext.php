<?php

declare(strict_types = 1);

namespace Financial\Tests\Shared\Infrastructure\Behat;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Mink\Session;
use Behat\MinkExtension\Context\RawMinkContext;
use Doctrine\ORM\EntityManager;
use Financial\Shared\Infrastructure\Doctrine\DatabaseConnections;
use Financial\Tests\Shared\Infrastructure\Mink\MinkHelper;
use Financial\Tests\Shared\Infrastructure\Mink\MinkSessionRequestHelper;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class ApiRequestContext extends RawMinkContext
{
    private MinkSessionRequestHelper $request;
    private array $attachments = [];
    private EntityManager $entityManager;
    private DatabaseConnections $connections;

    public function __construct(
        Session $session,
        EntityManager $entityManager,
        DatabaseConnections $connections
    )
    {
        $this->request = new MinkSessionRequestHelper(new MinkHelper($session));
        $this->entityManager = $entityManager;
        $this->connections = $connections;
    }

    /**
     * @Given I send a :method request to :url
     */
    public function iSendARequestTo($method, $url): void
    {
        $optionalParams = $this->prepareFilesToAttach();
        $this->request->sendRequest($method, $this->locatePath($url), $optionalParams);
    }

    /**
     * @Given I send a :method request to :url with body:
     */
    public function iSendARequestToWithBody($method, $url, PyStringNode $body): void
    {
        $optionalParams = array_merge($this->prepareFilesToAttach(), ['content' => $body->getRaw()]);
        $this->request->sendRequest($method, $this->locatePath($url), $optionalParams);
    }

    /**
     * @When I attach the file :file with mime type :mime from path :path to the request
     */
    public function iAttachFilesToMyRequest($file, $mime, $path)
    {
        $this->attachments[] = new UploadedFile(
            $path . $file,
            $file,
            $mime
        );
    }

    private function prepareFilesToAttach()
    {
        return [
            'files' => $this->attachments
        ];
    }

    /** @AfterScenario */
    public function cleanEnvironment(): void
    {
        $this->connections->clear();
        $this->connections->truncate();
    }
}
