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
    public function testPlateformIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/platform');

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

    #connexion

    public function testIdentification()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Log in')->form();
        $form['_username'] = 'Anna';
        $form['_password'] = 'Anna';
        $client->submit($form);


        $crawler = $client->followRedirect(); // Attention à bien récupérer le crawler mis à jour

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Ma plateforme d\'annonces")')->count());
        $this->assertSame(1, $crawler->filter('header:contains("Connecté en tant que Anna")')->count());
        $this->assertSame(0, $crawler->filter('a:contains("Connexion")')->count());
    }

    public function testFakeIdentification()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Log in')->form();
        $form['_username'] = 'Anna';
        $form['_password'] = 'password';
        $client->submit($form);


        $crawler = $client->followRedirect(); // Attention à bien récupérer le crawler mis à jour

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Ma plateforme d\'annonces")')->count());
        $this->assertSame(4, $crawler->filter('div:contains("Invalid credentials.")')->count());
        $this->assertSame(1, $crawler->filter('a:contains("Connexion")')->count());
    }
    public function testInvalidIdentification()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Log in')->form();
        $form['_username'] = '';
        $form['_password'] = '';
        $client->submit($form);


        $crawler = $client->followRedirect(); // Attention à bien récupérer le crawler mis à jour

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Ma plateforme d\'annonces")')->count());
//        $this->assertSame(1, $crawler->filter('div:contains("Veuillez  compléter ce champ.")')->count());
        $this->assertSame(1, $crawler->filter('a:contains("Connexion")')->count());
    }

    public function testUserRight()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Log in')->form();
        $form['_username'] = '';
        $form['_password'] = '';
        $client->submit($form);


        $crawler = $client->followRedirect(); // Attention à bien récupérer le crawler mis à jour


        $link = $crawler->selectLink('Benjamin : Recherche développeur Symfony.')->link();
        $crawler = $client->click($link);


        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Retour à la liste")')->count());
        $this->assertSame(0, $crawler->filter('html:contains("Modifier l\'annonce")')->count());
        $this->assertSame(0, $crawler->filter('html:contains("Supprimer l\'annonce")')->count());
    }
    public function testAthorRight()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Log in')->form();
        $form['_username'] = 'bgarnier';
        $form['_password'] = 'bgarnier';
        $client->submit($form);


        $crawler = $client->followRedirect(); // Attention à bien récupérer le crawler mis à jour


        $link = $crawler->selectLink('Benjamin : Recherche développeur Symfony.')->link();
        $crawler = $client->click($link);


        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Retour à la liste")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("Modifier l\'annonce")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("Supprimer l\'annonce")')->count());
    }
}
