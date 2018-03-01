<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdvertControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    # utilisateur non identifié
    public function testIndexUnknown()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Ma plateforme d\'annonces")')->count());
        $this->assertSame(0, $crawler->filter('a:contains("Déconnexion")')->count());
        $this->assertSame(1, $crawler->filter('a:contains("Connexion")')->count());
    }
}
