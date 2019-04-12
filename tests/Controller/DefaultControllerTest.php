<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testDom()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'pseudotest';
        $form['password'] = 'pass';
        $client->followRedirects();
        $crawler = $client->submit($form);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('a', $client->getResponse()->getContent());
        $this->assertCount(8, $crawler->filter('a'));
        $this->assertContains('Créer une tâche', $client->getResponse()->getContent());
        $this->assertContains('Consulter la liste des tâches à faire', $client->getResponse()->getContent());
        $this->assertContains('Consulter la liste des tâches terminées', $client->getResponse()->getContent());
        $this->assertContains('Consulter la liste des utilisateurs', $client->getResponse()->getContent());
    }
}
