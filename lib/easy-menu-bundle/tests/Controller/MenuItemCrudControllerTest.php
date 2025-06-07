<?php
declare(strict_types=1);

namespace Adeliom\EasyMenuBundle\Tests\Controller;

use Adeliom\EasyMenuBundle\Controller\MenuItemCrudController;
use Adeliom\EasyMenuBundle\Entity\MenuItemEntity;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

final class MenuItemCrudControllerTest extends TestCase
{
    public function testInformationsFieldsProvideName(): void
    {
        $controller = new class($this->createStub(ManagerRegistry::class)) extends MenuItemCrudController {
            public static function getEntityFqcn(): string
            {
                return MenuItemEntity::class;
            }
        };

        $fields = iterator_to_array($controller->informationsFields('new', null));

        self::assertSame('name', $fields[2]->getAsDto()->getProperty());
        self::assertSame('parent', $fields[3]->getAsDto()->getProperty());
    }
}
