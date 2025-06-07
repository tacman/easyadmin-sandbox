<?php
declare(strict_types=1);

namespace Adeliom\EasyFaqBundle\Tests;

use Adeliom\EasyFaqBundle\EventListener\DoctrineMappingListener;
use Adeliom\EasyFaqBundle\Entity\CategoryEntity;
use Adeliom\EasyFaqBundle\Entity\EntryEntity;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineMappingListenerTest extends KernelTestCase
{
    public function testAssociationsAreAdded(): void
    {
        self::bootKernel();
        $em = self::getContainer()->get('doctrine')->getManager();
        $listener = new DoctrineMappingListener(Entry::class, Category::class);
        $entryMetadata = $em->getClassMetadata(Entry::class);
        $categoryMetadata = $em->getClassMetadata(Category::class);
        $listener->loadClassMetadata(new LoadClassMetadataEventArgs($entryMetadata, $em));
        $listener->loadClassMetadata(new LoadClassMetadataEventArgs($categoryMetadata, $em));
        self::assertTrue($entryMetadata->hasAssociation('category'));
        self::assertTrue($categoryMetadata->hasAssociation('entries'));
    }
}
