<?php
declare(strict_types=1);

namespace Adeliom\EasyConfigBundle\Tests\Repository;

use Adeliom\EasyConfigBundle\Tests\DatabaseSetupTrait;
use Adeliom\EasyConfigBundle\Tests\Fixtures\ConfigFixture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ConfigRepositoryTest extends KernelTestCase
{
    use DatabaseSetupTrait;

    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        $this->em = $this->bootKernelWithMemoryDatabase();
        (new ConfigFixture())->load($this->em);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->restoreDatabaseEnv();
    }

    public function testGetByKey(): void
    {
        $repository = static::getContainer()->get('easy_config.config_repository');
        $config = $repository->getByKey('site_name');

        self::assertNotNull($config);
        self::assertSame('EasyAdmin', $config->getValue());
    }
}
