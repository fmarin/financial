<?php

declare(strict_types=1);

namespace Financial\Tests\Shared\Infrastructure\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Financial\Shared\Infrastructure\Bus\Event\DomainEventJsonDeserializer;
use Financial\Shared\Infrastructure\Bus\Event\InMemory\InMemorySymfonyEventBus;
use Financial\Shared\Infrastructure\Doctrine\DatabaseConnections;

final class ApplicationFeatureContext implements Context
{
    private DatabaseConnections $connections;
    private InMemorySymfonyEventBus $bus;
    private DomainEventJsonDeserializer $deserializer;

    public function __construct(
        DatabaseConnections $connections,
        InMemorySymfonyEventBus $bus,
        DomainEventJsonDeserializer $deserializer
    ) {
        $this->connections = $connections;
        $this->bus = $bus;
        $this->deserializer = $deserializer;
    }

    /** @BeforeScenario */
    public function cleanEnvironment(): void
    {
        $this->connections->clear();
        $this->connections->truncate();
    }

    /**
     * @Given /^I send an event to the event bus:$/
     */
    public function iSendAnEventToTheEventBus(PyStringNode $event): void
    {
        $domainEvent = $this->deserializer->deserialize($event->getRaw());

        $this->bus->publish($domainEvent);
    }
}
