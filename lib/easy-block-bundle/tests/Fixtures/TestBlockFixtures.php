<?php
declare(strict_types=1);

namespace Adeliom\EasyBlockBundle\Tests\Fixtures;

use Adeliom\EasyBlockBundle\Entity\Block;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestBlockFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $block1 = new Block();
        $block1->setName('Alpha Block');
        $block1->setKey('alpha-key');
        $block1->setType(DummyBlockType::class);
        $block1->setStatus(true);
        $block1->setSettings(['name' => 'Alpha']);
        $manager->persist($block1);

        $block2 = new Block();
        $block2->setName('Omega Block');
        $block2->setKey('omega-key');
        $block2->setType(DummyBlockType::class);
        $block2->setStatus(false);
        $block2->setSettings(['name' => 'Omega']);
        $manager->persist($block2);

        $manager->flush();
    }
}
