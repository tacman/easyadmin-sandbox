<?php

namespace Adeliom\EasyBlogBundle\Tests\Repository;

use Adeliom\EasyBlogBundle\Tests\BlogTestCase;
use Adeliom\EasyBlogBundle\Entity\PostEntity;
use App\Repository\EasyBlog\CategoryRepository;
use App\Repository\EasyBlog\PostRepository;

class PostRepositoryTest extends BlogTestCase
{
    public function testGetPublished(): void
    {
        $repo = new PostRepository(new \Adeliom\EasyBlogBundle\Tests\SimpleManagerRegistry($this->em));
        $posts = $repo->getPublished();
        $this->assertCount(2, $posts);
    }

    public function testGetByCategory(): void
    {
        $registry = new \Adeliom\EasyBlogBundle\Tests\SimpleManagerRegistry($this->em);
        $repo = new PostRepository($registry);
        $cat = (new CategoryRepository($registry))->findOneBy(['slug' => 'cat']);
        $posts = $repo->getByCategory($cat);
        $this->assertCount(2, $posts);
    }

    public function testGetBySlug(): void
    {
        $registry = new \Adeliom\EasyBlogBundle\Tests\SimpleManagerRegistry($this->em);
        $repo = new PostRepository($registry);
        $cat = (new CategoryRepository($registry))->findOneBy(['slug' => 'cat']);
        $post = $repo->getBySlug('post-1', $cat);
        $this->assertInstanceOf(PostEntity::class, $post);
        $this->assertSame('post-1', $post->getSlug());
    }
}
