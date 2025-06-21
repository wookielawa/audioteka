<?php

namespace App\Tests\Functional;

use App\Tests\LoadFixturesTrait;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    use LoadFixturesTrait;
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->client->disableReboot();
        $this->client->catchExceptions(true);

        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();

        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->createSchema($metadata);
    }



    protected function getJsonResponse(): array
    {
        return json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }
}