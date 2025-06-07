<?php

namespace Adeliom\EasyBlogBundle\Tests\EventListener;

use Adeliom\EasyBlogBundle\EventListener\BlogListener;
use Adeliom\EasyBlogBundle\Tests\BlogTestCase;
use Adeliom\EasyBlogBundle\Tests\SimpleManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class BlogListenerTest extends BlogTestCase
{
    public function testSetRequestLayoutForPost(): void
    {
        $registry = new SimpleManagerRegistry($this->em);
        $listener = new BlogListener(
            $registry->getRepository(\Adeliom\EasyBlogBundle\Entity\PostEntity::class),
            $registry->getRepository(\Adeliom\EasyBlogBundle\Entity\CategoryEntity::class),
            ['root_path' => '/blog']
        );

        $request = new Request([], [], [], [], [], ['HTTP_HOST' => 'localhost', 'REQUEST_URI' => '/blog/cat/post-1']);
        $kernel = $this->createMock(HttpKernelInterface::class);
        $event = new RequestEvent($kernel, $request, HttpKernelInterface::MAIN_REQUEST);

        $listener->setRequestLayout($event);

        $this->assertTrue($request->attributes->has('_easy_blog_category'));
        $this->assertTrue($request->attributes->has('_easy_blog_post'));
    }

    public function testSetRequestLayoutForRoot(): void
    {
        $registry = new SimpleManagerRegistry($this->em);
        $listener = new BlogListener(
            $registry->getRepository(\Adeliom\EasyBlogBundle\Entity\PostEntity::class),
            $registry->getRepository(\Adeliom\EasyBlogBundle\Entity\CategoryEntity::class),
            ['root_path' => '/blog']
        );

        $request = new Request([], [], [], [], [], ['HTTP_HOST' => 'localhost', 'REQUEST_URI' => '/blog']);
        $kernel = $this->createMock(HttpKernelInterface::class);
        $event = new RequestEvent($kernel, $request, HttpKernelInterface::MAIN_REQUEST);

        $listener->setRequestLayout($event);

        $this->assertTrue($request->attributes->has('_easy_blog_root'));
    }
}
