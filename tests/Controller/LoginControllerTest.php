<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class LoginControllerTest extends WebTestCase
{

    private KernelBrowser|null $client = null;
    private object|null $urlGenerator = null;

    public function setUp(): void
    {
        $this->client = static::createClient();

        $this->urlGenerator = $this->client->getContainer()->get("router.default");
    }

    public function testLoginIsUp(): void
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate("app_login"));

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLogoutIsUp(): void
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate("app_logout"));
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
