<?php

namespace Adeliom\EasyBlogBundle\Tests\Routing;

use Adeliom\EasyBlogBundle\Routing\BlogPostLoader;
use Adeliom\EasyBlogBundle\Tests\BlogTestCase;

class BlogPostLoaderTest extends BlogTestCase
{
    public function testSupports(): void
    {
        $repo = new \Adeliom\EasyBlogBundle\Repository\PostRepository(new \Adeliom\EasyBlogBundle\Tests\SimpleManagerRegistry($this->em));
        $loader = new BlogPostLoader('Controller', '', $repo, ['root_path' => '/blog']);
        $this->assertTrue($loader->supports(null, 'easy_blog_post'));
        $this->assertFalse($loader->supports(null, 'foo'));
    }

    public function testLoad(): void
    {
        $repo = new \Adeliom\EasyBlogBundle\Repository\PostRepository(new \Adeliom\EasyBlogBundle\Tests\SimpleManagerRegistry($this->em));
        $loader = new BlogPostLoader('Controller', '', $repo, ['root_path' => '/blog']);
        $collection = $loader->load([], 'easy_blog_post');
        $route = $collection->get('easy_blog_post_index');
        $this->assertSame('/blog/{category}/{post}', $route->getPath());
    }
}
