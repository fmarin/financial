<?php

declare(strict_types = 1);

namespace Financial\Tests\Shared\Infrastructure\Behat;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Mink\Session;
use Behat\MinkExtension\Context\RawMinkContext;
use Financial\Tests\Shared\Infrastructure\Mink\MinkHelper;
use Financial\Tests\Shared\Infrastructure\Mink\MinkSessionRequestHelper;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class ApiRequestContext extends RawMinkContext
{
    private MinkSessionRequestHelper $request;
    private array $attachments = [];

    public function __construct(Session $session)
    {
        $this->request = new MinkSessionRequestHelper(new MinkHelper($session));
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
}
