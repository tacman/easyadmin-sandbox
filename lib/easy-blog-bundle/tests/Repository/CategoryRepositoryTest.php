<?php

namespace Adeliom\EasyBlogBundle\Tests\Repository;

use Adeliom\EasyBlogBundle\Tests\BlogTestCase;
use Adeliom\EasyBlogBundle\Entity\CategoryEntity;
use App\Repository\EasyBlog\CategoryRepository;

class CategoryRepositoryTest extends BlogTestCase
{
    public function testGetPublished(): void
    {
        $repo = new CategoryRepository(new \Adeliom\EasyBlogBundle\Tests\SimpleManagerRegistry($this->em));
        $result = $repo->getPublished();
        $this->assertCount(1, $result);
    }

    public function testGetBySlug(): void
    {
        $repo = new CategoryRepository(new \Adeliom\EasyBlogBundle\Tests\SimpleManagerRegistry($this->em));
        $cat = $repo->getBySlug('cat');
        $this->assertInstanceOf(CategoryEntity::class, $cat);
    }
}
