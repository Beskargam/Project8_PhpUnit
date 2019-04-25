<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testDom()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'pseudotest';
        $form['password'] = 'pass';
        $client->followRedirects();
        $client->submit($form);

        $client->request('GET', '/users');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Nom d\'utilisateur', $client->getResponse()->getContent());
        $this->assertContains('Adresse d\'utilisateur', $client->getResponse()->getContent());
    }

    public function testAuthorization()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'pseudotest'; // user without admin role
        $form['password'] = 'pass';
        $client->followRedirects();
        $client->submit($form);

        $client->request('GET', '/admin/users/10/edit');

        $this->assertSame(403, $client->getResponse()->getStatusCode()); // Unauthorized 403
    }

    public function testEditUser()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'pseudotestadmin';
        $form['password'] = 'pass';
        $client->followRedirects();
        $client->submit($form);

        $crawler = $client->request('GET', '/admin/users/3/edit');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Modifier l\'utilisateur', $client->getResponse()->getContent());

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'pseudotest2PhpUnit';
        $form['user[email]'] = 'auredev@gmx.com';
        $form['user[plainPassword][first]'] = 'pass';
        $form['user[plainPassword][second]'] = 'pass';
        $form['user[roles]'] = 'ROLE_USER';
        $client->followRedirects();
        $client->submit($form);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Nom d\'utilisateur', $client->getResponse()->getContent());
    }

    /*public function testAddUser()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/create');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Enregistrement', $client->getResponse()->getContent());

        $form = $crawler->selectButton('S\'enregistrer')->form();
        $form['user[username]'] = 'AddedWithPhpUnit';
        $form['user[email]'] = 'zenways@laposte.net';
        $form['user[plainPassword][first]'] = 'pass';
        $form['user[plainPassword][second]'] = 'pass';
        $form['user[roles]'] = 'ROLE_USER';
        $client->followRedirects();
        $crawler = $client->submit($form);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('form', $client->getResponse()->getContent());
        $this->assertCount(1, $crawler->filter('form'));
        $this->assertCount(3, $crawler->filter('input'));
        $this->assertCount(1, $crawler->filter('button'));
    }*/
}
