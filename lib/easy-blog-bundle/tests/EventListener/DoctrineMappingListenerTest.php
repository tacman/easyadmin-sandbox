<?php

namespace Adeliom\EasyBlogBundle\Tests\EventListener;

use Adeliom\EasyBlogBundle\Entity\CategoryEntity;
use Adeliom\EasyBlogBundle\Entity\PostEntity;
use Adeliom\EasyBlogBundle\EventListener\DoctrineMappingListener;
use Adeliom\EasyBlogBundle\Tests\BlogTestCase;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;

class DoctrineMappingListenerTest extends BlogTestCase
{
    public function testLoadClassMetadata(): void
    {
        $listener = new DoctrineMappingListener(PostEntity::class, CategoryEntity::class);

        $metaPost = new ClassMetadata(PostEntity::class);
        $argsPost = new LoadClassMetadataEventArgs($metaPost, $this->em);
        $listener->loadClassMetadata($argsPost);
        $this->assertTrue($metaPost->hasAssociation('category'));

        $metaCategory = new ClassMetadata(CategoryEntity::class);
        $argsCategory = new LoadClassMetadataEventArgs($metaCategory, $this->em);
        $listener->loadClassMetadata($argsCategory);
        $this->assertTrue($metaCategory->hasAssociation('posts'));
    }
}
