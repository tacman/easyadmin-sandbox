<?php

declare(strict_types=1);

namespace Adeliom\EasyFieldsBundle\Tests\Traits;

use Adeliom\EasyFieldsBundle\Traits\PositionSortableTrait;
use PHPUnit\Framework\TestCase;

class TestSortableEntity
{
    use PositionSortableTrait;
}

class PositionSortableTraitTest extends TestCase
{
    public function testGetSet(): void
    {
        $entity = new \Adeliom\EasyFieldsBundle\Tests\Traits\TestSortableEntity();
        $entity->setLft(1);
        $entity->setLvl(2);
        $entity->setRgt(3);
        $entity->setRoot(4);
        $this->assertSame(1, $entity->getLft());
        $this->assertSame(2, $entity->getLvl());
        $this->assertSame(3, $entity->getRgt());
        $this->assertSame(4, $entity->getRoot());
        $this->assertSame(1, $entity->getSortableData('lft'));
    }
}
