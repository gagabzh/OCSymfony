<?php
/**
 * Created by PhpStorm.
 * User: bgarnier
 * Date: 01/03/2018
 * Time: 14:49
 */

namespace Tests\AppBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiAdvertControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/adverts/200');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());

    }
    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/adverts/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }
}