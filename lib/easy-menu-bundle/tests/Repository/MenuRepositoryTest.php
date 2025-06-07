<?php
declare(strict_types=1);

namespace Adeliom\EasyMenuBundle\Tests\Repository;

use Adeliom\EasyMenuBundle\Tests\DoctrineOrmTestCase;
use Adeliom\EasyMenuBundle\Entity\MenuEntity;
use Adeliom\EasyMenuBundle\Entity\MenuItemEntity;

final class MenuRepositoryTest extends DoctrineOrmTestCase
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
        $repo = $this->entityManager->getRepository(MenuEntity::class);
        $repo->setConfig(['enabled' => true, 'ttl' => 3600]);

        $ref = new \ReflectionClass($repo);
        $enabled = $ref->getProperty('cacheEnabled');
        $enabled->setAccessible(true);
        $ttl = $ref->getProperty('cacheTtl');
        $ttl->setAccessible(true);

        self::assertTrue($enabled->getValue($repo));
        self::assertSame(3600, $ttl->getValue($repo));
    }
}
