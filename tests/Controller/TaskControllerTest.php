<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testDomTodo()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'pseudotestadmin';
        $form['password'] = 'pass';
        $client->followRedirects();
        $client->submit($form);

        $crawler = $client->request('GET', '/tasks/todo');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Créer une tâche', $client->getResponse()->getContent());
        $this->assertContains('Consulter la liste des tâches terminées', $client->getResponse()->getContent());
        $this->assertContains('a', $client->getResponse()->getContent());
        $this->assertCount(6, $crawler->filter('a.btn'));
    }

    public function testDomFinish()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'pseudotestadmin';
        $form['password'] = 'pass';
        $client->followRedirects();
        $client->submit($form);

        $crawler = $client->request('GET', '/tasks/finish');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Créer une tâche', $client->getResponse()->getContent());
        $this->assertContains('Consulter la liste des tâches à faire', $client->getResponse()->getContent());
        $this->assertContains('a', $client->getResponse()->getContent());
        $this->assertCount(6, $crawler->filter('a.btn'));
    }

    public function testAddTask()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'pseudotestadmin';
        $form['password'] = 'pass';
        $client->followRedirects();
        $client->submit($form);

        $crawler = $client->request('GET', '/tasks/create');


        $form = $crawler->selectButton('Enregistrer')->form();
        $form['task[title]'] = 'AddedWithPhpUnit';
        $form['task[content]'] = 'Une description de tâche ajouté avec PHPUnit';
        $client->followRedirects();
        $crawler = $client->submit($form);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('AddedWithPhpUnit', $client->getResponse()->getContent());
        $this->assertContains('Une description de tâche ajouté avec PHPUnit', $client->getResponse()->getContent());
        $this->assertContains('Créer une tâche', $client->getResponse()->getContent());
        $this->assertContains('Consulter la liste des tâches terminées', $client->getResponse()->getContent());
    }

    public function testEditTask()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'pseudotestadmin';
        $form['password'] = 'pass';
        $client->followRedirects();
        $client->submit($form);

        $crawler = $client->request('GET', '/tasks/14/edit');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Enregistrer')->form();
        $form['task[title]'] = 'Task modified with PHPUnit';
        $form['task[content]'] = 'Une description de tâche ajoutée avec PHPUnit et modifiée par la suite';
        $client->followRedirects();
        $crawler = $client->submit($form);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Créer une tâche', $client->getResponse()->getContent());
        $this->assertContains('Consulter la liste des tâches terminées', $client->getResponse()->getContent());
        $this->assertContains('a', $client->getResponse()->getContent());
        $this->assertCount(6, $crawler->filter('a.btn'));
    }
}
