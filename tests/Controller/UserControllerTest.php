<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;
    private object|null $urlGenerator = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail(["email" => "admin@mail.fr"]);

        $this->urlGenerator = $this->client->getContainer()->get("router.default");

        $this->client->loginUser($testUser);
    }

    public function testListUserActionIsUp(): void
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate("user_list"));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testCreateUserActionIsUp(): void
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_create'));
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[nom]'] = 'VOIRIOT';
        $form['user[prenom]'] = 'Alban';
        $form['user[username]'] = 'avoiriot';
        $form['user[password][first]'] = 'PassWord2001!';
        $form['user[password][second]'] = 'PassWord2001!';
        $form['user[email]'] = 'alban.voiriot3@gmail.com';
        $form['user[role]'] = 'ROLE_USER';
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert.alert-success', "L'utilisateur a bien été ajouté.");
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_list'));
    }

    public function testEditUserActionIsUp(): void
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_edit', ['id' => 14]));
        $form = $crawler->selectButton('Modifier')->form();
        $form['user[nom]'] = 'VOIRIOT';
        $form['user[prenom]'] = 'Alban';
        $form['user[username]'] = 'avoiriot';
        $form['user[password][first]'] = 'PassWord2001!';
        $form['user[password][second]'] = 'PassWord2001!';
        $form['user[email]'] = 'alban.voiriot@gmail.com';
        $form['user[role]'] = 'ROLE_USER';
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert.alert-success', "L'utilisateur a bien été modifié");
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_list'));
    }
}
