<?php

namespace Adeliom\EasyBlogBundle\Tests\Controller;

use Adeliom\EasyBlogBundle\Controller\CategoryController;
use Adeliom\EasyBlogBundle\Event\EasyBlogCategoryEvent;
use Adeliom\EasySeoBundle\Services\BreadcrumbCollection;
use Adeliom\EasyBlogBundle\Tests\BlogTestCase;
use Adeliom\EasyBlogBundle\Tests\SimpleManagerRegistry;
use Adeliom\EasyBlogBundle\Entity\CategoryEntity;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class CategoryControllerTest extends BlogTestCase
{
    private function createController(): CategoryController
    {
        $registry = new SimpleManagerRegistry($this->em);
        $controller = new CategoryController($registry);

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(EasyBlogCategoryEvent::NAME, fn(EasyBlogCategoryEvent $e) => $e);

        $twig = new Environment(new ArrayLoader([
            '@EasyBlog/front/category.html.twig' => 'category',
            '@EasyBlog/front/root.html.twig' => 'root',
        ]));

        $generator = new class() implements \Symfony\Component\Routing\Generator\UrlGeneratorInterface {
            public function generate(string $name, array $parameters = [], int $referenceType = self::ABSOLUTE_PATH): string { return '/'; }
            public function setContext(\Symfony\Component\Routing\RequestContext $context): void {}
            public function getContext(): \Symfony\Component\Routing\RequestContext { return new \Symfony\Component\Routing\RequestContext(); }
        };
        $breadcrumb = new BreadcrumbCollection();
        $breadcrumb->setGenerator($generator);

        $container = new Container();
        $container->set('event_dispatcher', $dispatcher);
        $container->set('twig', $twig);
        $container->set('easy_seo.breadcrumb', $breadcrumb);
        $container->set('parameter_bag', new ParameterBag([
            'easy_blog.post.class' => \Adeliom\EasyBlogBundle\Entity\PostEntity::class,
            'easy_blog.category.class' => \Adeliom\EasyBlogBundle\Entity\CategoryEntity::class,
        ]));
        $controller->setContainer($container);

        return $controller;
    }

    public function testIndex(): void
    {
        $repo = (new SimpleManagerRegistry($this->em))->getRepository(CategoryEntity::class);
        $category = $repo->findOneBy(['slug' => 'cat']);
        $request = new Request([], [], ['_easy_blog_category' => $category]);

        $response = $this->createController()->index($request, 'cat');
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testBlogRoot(): void
    {
        $request = new Request([], [], ['_easy_blog_root' => true]);

        $response = $this->createController()->blogRoot($request);
        $this->assertSame(200, $response->getStatusCode());
    }
}
