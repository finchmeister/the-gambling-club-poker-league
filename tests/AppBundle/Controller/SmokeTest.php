<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeTest extends WebTestCase
{
    /**
     * @dataProvider dataProviderTestUrls
     */
    public function testUrls($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), $this->getErrorString($url, $client->getResponse()->getContent()));
    }

    public function dataProviderTestUrls(): array
    {
        return  [
            ['/',],
            ['player/',],
            ['player/1',],
            ['host/1',],
        ];
    }

    private function getErrorString(string $url, string $content): string
    {
        return <<<EOL
Failed url: $url
================
$content";
EOL;
    }
}
