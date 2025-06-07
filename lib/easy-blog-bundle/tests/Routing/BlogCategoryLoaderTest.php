<?php

namespace Adeliom\EasyBlogBundle\Tests\Routing;

use Adeliom\EasyBlogBundle\Routing\BlogCategoryLoader;
use Adeliom\EasyBlogBundle\Tests\BlogTestCase;
use Symfony\Component\Routing\RouteCollection;

class BlogCategoryLoaderTest extends BlogTestCase
{
    public function testSupports(): void
    {
        $repo = new \Adeliom\EasyBlogBundle\Repository\CategoryRepository(new \Adeliom\EasyBlogBundle\Tests\SimpleManagerRegistry($this->em));
        $loader = new BlogCategoryLoader('Controller', '', $repo, ['root_path' => '/blog']);
        $this->assertTrue($loader->supports(null, 'easy_blog_category'));
        $this->assertFalse($loader->supports(null, 'foo'));
    }

    public function testLoad(): void
    {
        $repo = new \Adeliom\EasyBlogBundle\Repository\CategoryRepository(new \Adeliom\EasyBlogBundle\Tests\SimpleManagerRegistry($this->em));
        $loader = new BlogCategoryLoader('Controller', '', $repo, ['root_path' => '/blog']);
        $collection = $loader->load([], 'easy_blog_category');
        $this->assertInstanceOf(RouteCollection::class, $collection);
        $route = $collection->get('easy_blog_category_index');
        $this->assertSame('/blog/{category}', $route->getPath());
    }
}
