<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testDom()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('form', $client->getResponse()->getContent());
        $this->assertCount(1, $crawler->filter('form'));
        $this->assertCount(3, $crawler->filter('input'));
        $this->assertCount(1, $crawler->filter('button'));
    }

    public function testForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'pseudotest';
        $form['password'] = 'pass';
        $client->followRedirects();
        $client->submit($form);

        $this->assertContains('Consulter la liste des utilisateurs', $client->getResponse()->getContent());
    }

    public function testLogout()
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'pseudotest';
        $form['password'] = 'pass';
        $client->followRedirects();
        $crawler = $client->submit($form);
        $this->assertContains('Consulter la liste des utilisateurs', $client->getResponse()->getContent());

        $link = $crawler
            ->filter('a:contains("Déconnexion")')
            ->eq(0)
            ->link();
        $client->followRedirects();
        $crawler = $client->click($link);

        $this->assertContains('form', $client->getResponse()->getContent());
        $this->assertCount(1, $crawler->filter('form'));
        $this->assertCount(3, $crawler->filter('input'));
        $this->assertCount(1, $crawler->filter('button'));
    }
}
