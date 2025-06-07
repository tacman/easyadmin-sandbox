<?php
declare(strict_types=1);

namespace Adeliom\EasyMenuBundle\Tests\Twig;

use Adeliom\EasyMenuBundle\Entity\MenuEntity;
use Adeliom\EasyMenuBundle\Entity\MenuItemEntity;
use Adeliom\EasyMenuBundle\Exceptions\MenuNotFoundException;
use Adeliom\EasyMenuBundle\Exceptions\TemplateNotFoundException;
use Adeliom\EasyMenuBundle\Twig\EasyMenuExtension;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

final class EasyMenuExtensionTest extends TestCase
{
    private function createRepository(MenuEntity $menu): ObjectRepository
    {
        return new class($menu) implements ObjectRepository {
            public function __construct(private MenuEntity $menu) {}
            public function find($id) {}
            public function findAll() { return []; }
            public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null) { return []; }
            public function findOneBy(array $criteria) { return $this->menu; }
            public function getClassName() { return MenuEntity::class; }
            public function findOneByCode(string $code) { return $this->menu; }
        };
    }

    private function createItemRepository(MenuItemEntity $item): ObjectRepository
    {
        return new class($item) implements ObjectRepository {
            public function __construct(private MenuItemEntity $item) {}
            public function find($id) {}
            public function findAll() { return []; }
            public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null) { return []; }
            public function findOneBy(array $criteria) { return $this->item; }
            public function getClassName() { return MenuItemEntity::class; }
        };
    }

    private function createExtension(MenuEntity $menu, MenuItemEntity $rootItem, Environment $twig): EasyMenuExtension
    {
        $menuRepository = $this->createRepository($menu);
        $itemRepository = $this->createItemRepository($rootItem);

        $em = $this->createMock(EntityManagerInterface::class);
        $em->method('getRepository')->willReturnMap([
            [MenuEntity::class, $menuRepository],
            [MenuItemEntity::class, $itemRepository],
        ]);

        return new EasyMenuExtension($twig, $em, MenuEntity::class, MenuItemEntity::class);
    }

    public function testRenderEasyMenuReturnsMarkup(): void
    {
        $menu = new MenuEntity();
        $menu->setCode('main');
        $rootItem = new MenuItemEntity();
        $rootItem->setMenu($menu);

        $twig = new Environment(new ArrayLoader([
            '@EasyMenu/front/menus/main.html.twig' => 'Menu: {{ menu.code }}'
        ]));
        $extension = $this->createExtension($menu, $rootItem, $twig);

        $markup = $extension->renderEasyMenu($twig, [], 'main');
        self::assertSame('Menu: main', (string) $markup);
    }

    public function testCustomTemplate(): void
    {
        $menu = new MenuEntity();
        $menu->setCode('main');
        $rootItem = new MenuItemEntity();
        $rootItem->setMenu($menu);

        $twig = new Environment(new ArrayLoader([
            '@EasyMenu/front/menus/main.html.twig' => 'unused',
            'custom.html.twig' => 'Custom: {{ menu.code }}'
        ]));
        $extension = $this->createExtension($menu, $rootItem, $twig);
        $markup = $extension->renderEasyMenu($twig, [], 'main', ['template' => 'custom.html.twig']);
        self::assertSame('Custom: main', (string) $markup);
    }

    public function testMenuNotFoundThrowsException(): void
    {
        $menuRepository = new class implements ObjectRepository {
            public function find($id) {}
            public function findAll() { return []; }
            public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null) { return []; }
            public function findOneBy(array $criteria) { return null; }
            public function getClassName() { return MenuEntity::class; }
            public function findOneByCode(string $code) { return null; }
        };
        $itemRepository = $this->createItemRepository(new MenuItemEntity());
        $em = $this->createMock(EntityManagerInterface::class);
        $em->method('getRepository')->willReturnMap([
            [Menu::class, $menuRepository],
            [MenuItemEntity::class, $itemRepository],
        ]);
        $twig = new Environment(new ArrayLoader(['@EasyMenu/front/menus/main.html.twig' => '']));
        $extension = new EasyMenuExtension($twig, $em, MenuEntity::class, MenuItemEntity::class);
        $this->expectException(MenuNotFoundException::class);
        $extension->renderEasyMenu($twig, [], 'main');
    }

    public function testTemplateNotFoundThrowsException(): void
    {
        $menu = new MenuEntity();
        $menu->setCode('main');
        $menuRepository = $this->createRepository($menu);
        $itemRepository = $this->createItemRepository(new MenuItemEntity());
        $em = $this->createMock(EntityManagerInterface::class);
        $em->method('getRepository')->willReturnMap([
            [MenuEntity::class, $menuRepository],
            [MenuItemEntity::class, $itemRepository],
        ]);
        $twig = new Environment(new ArrayLoader());
        $extension = new EasyMenuExtension($twig, $em, MenuEntity::class, MenuItemEntity::class);
        $this->expectException(TemplateNotFoundException::class);
        $extension->renderEasyMenu($twig, [], 'main');
    }
}
