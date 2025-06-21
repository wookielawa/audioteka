<?php

namespace App\Tests\Integration;

use App\Tests\LoadFixturesTrait;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase as BaseKernelTestCase;
class KernelTestCase extends BaseKernelTestCase
{
    use LoadFixturesTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $this->entityManager = static::getContainer()->get('doctrine')->getManager();

        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->createSchema($metadata);
    }
}