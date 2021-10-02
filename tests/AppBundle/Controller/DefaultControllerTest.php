<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testUrls()
    {
        $urls = [
            '/',
            'player/',
            'player/1',
            'host/1',
        ];

        foreach ($urls as $url) {
            $client = static::createClient();
            $client->request('GET', $url);
            $this->assertEquals(200, $client->getResponse()->getStatusCode(), $url);
        }
    }
}
