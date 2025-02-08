<?php

namespace App\Tests\Scrape;

use Symfony\Component\Panther\PantherTestCase;

class ExampleTest extends PantherTestCase
{
    public function testSomething(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');

        $this->assertSelectorTextContains('h1', 'Hello World');
    }
}
