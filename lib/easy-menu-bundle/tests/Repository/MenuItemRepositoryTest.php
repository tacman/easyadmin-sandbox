<?php
declare(strict_types=1);

namespace Adeliom\EasyMenuBundle\Tests\Repository;

use Adeliom\EasyMenuBundle\Tests\DoctrineOrmTestCase;
use Adeliom\EasyMenuBundle\Entity\MenuEntity;
use Adeliom\EasyMenuBundle\Entity\MenuItemEntity;

final class MenuItemRepositoryTest extends DoctrineOrmTestCase
{
    protected function getMetadata(): array
    {
        return [
            $this->entityManager->getClassMetadata(MenuEntity::class),
            $this->entityManager->getClassMetadata(MenuItemEntity::class),
        ];
    }

    public function testSetConfigUpdatesProperties(): void
    {
        $repo = $this->entityManager->getRepository(MenuItemEntity::class);
        $repo->setConfig(['enabled' => true, 'ttl' => 1800]);

        $ref = new \ReflectionClass($repo);
        $enabled = $ref->getProperty('cacheEnabled');
        $enabled->setAccessible(true);
        $ttl = $ref->getProperty('cacheTtl');
        $ttl->setAccessible(true);

        self::assertTrue($enabled->getValue($repo));
        self::assertSame(1800, $ttl->getValue($repo));
    }
}
