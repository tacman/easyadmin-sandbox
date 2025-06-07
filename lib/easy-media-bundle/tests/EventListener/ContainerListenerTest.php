<?php

declare(strict_types=1);

namespace Adeliom\EasyMediaBundle\Tests\EventListener;

use Adeliom\EasyMediaBundle\EventListener\ContainerListener;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ContainerListenerTest extends TestCase
{
    public function testContainerIsStored(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $listener = new ContainerListener($container);
        self::assertSame($container, $listener->getContainer());
    }
}
