<?php
declare(strict_types=1);

namespace Adeliom\EasyMenuBundle\Tests\Fixtures;

use Adeliom\EasyCommonBundle\Enum\ThreeStateStatusEnum;
use Adeliom\EasyMenuBundle\Entity\MenuEntity;
use Adeliom\EasyMenuBundle\Entity\MenuItemEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MenuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $menu = new MenuEntity();
        $menu->setCode('main');
        $menu->setName('Main menu');
        $menu->setStatus(true);

        $item = new MenuItemEntity();
        $item->setName('Home');
        $item->setUrl('/');
        $item->setMenu($menu);
        $item->setState(ThreeStateStatusEnum::PUBLISHED);
        $menu->addItem($item);

        $manager->persist($menu);
        $manager->persist($item);
        $manager->flush();
    }
}
