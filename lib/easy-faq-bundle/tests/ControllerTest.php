<?php
declare(strict_types=1);

namespace Adeliom\EasyFaqBundle\Tests;

use Adeliom\EasyMediaBundle\Tests\Fixtures\FixturesTrait;
use Adeliom\EasyFaqBundle\Tests\Fixtures\FaqFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerTest extends WebTestCase
{
    use FixturesTrait;

    public function testCategoryPage(): void
    {
        $client = static::createClient();
        $this->loadFixtures([new FaqFixtures()]);
        $client->request('GET', '/faq/faq-category');
        self::assertResponseIsSuccessful();
    }

    public function testEntryPage(): void
    {
        $client = static::createClient();
        $this->loadFixtures([new FaqFixtures()]);
        $client->request('GET', '/faq/faq-category/faq-entry');
        self::assertResponseIsSuccessful();
    }
}
