<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;
    private object|null $urlGenerator = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail(["email" => "alban.voiriot@gmail.com"]);

        $this->urlGenerator = $this->client->getContainer()->get("router.default");

        $this->client->loginUser($testUser);
    }

    public function testListActionIsUp(): void
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate("task_list"));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testCreateActionIsUp(): void
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_create'));
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Task #1';
        $form['task[content]'] = 'Faire cette tâche là';
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testEditActionIsUp(): void
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_edit', ['id' => 27]));
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Task #1';
        $form['task[content]'] = 'Modifier cette tâche là';
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testToggleTaskActionIsUp(): void
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_list'));
        $form = $crawler->filter('.btnMarquer')->form();
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testDeleteTaskActionIsUp(): void
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_list'));
        $form = $crawler->selectButton('Supprimer')->form();
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert.alert-success', 'La tâche a bien été supprimée.');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
