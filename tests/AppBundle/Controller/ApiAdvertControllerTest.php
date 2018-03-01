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
    public function testErrorShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/adverts/200');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());

    }
    public function testShow()
    {
        $client = static::createClient();

        $client->request('GET', '/api/adverts/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ));
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Alexendre',$responseData['author']);
    }
    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/adverts');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ));
        echo $client->getResponse()->getContent();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(5,count($responseData));;
    }

    public function testPostList()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/api/adverts');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ));
    }
}