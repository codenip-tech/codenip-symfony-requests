<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RegisterActionControllerTest extends WebTestCase
{
    private const ENDPOINT = '/register';

    private static ?KernelBrowser $client = null;

    public function setUp(): void
    {
        parent::setUp();

        if (null === self::$client) {
            self::$client = static::createClient();
            self::$client->setServerParameters(
                [
                    'CONTENT_TYPE' => 'application/json',
                    'HTTP_ACCEPT' => 'application/json',
                ]
            );
        }
    }

    public function testRegisterAction(): void
    {
        $payload = [
            'name' => 'Juan',
            'email' => 'juan@api.com',
            'password' => 'some-password',
        ];

        self::$client->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$client->getResponse();

        self::assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }

    public function testRegisterActionEmptyName(): void
    {
        $payload = [
            'name' => '',
            'email' => 'juan@api.com',
            'password' => 'some-password',
        ];

        self::$client->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$client->getResponse();

        self::assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testRegisterActionInvalidEmail(): void
    {
        $payload = [
            'name' => 'Juan',
            'email' => 'invalid-email',
            'password' => 'some-password',
        ];

        self::$client->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$client->getResponse();

        self::assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testRegisterActionInvalidPassword(): void
    {
        $payload = [
            'name' => 'Juan',
            'email' => 'juan@api.com',
            'password' => '1',
        ];

        self::$client->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$client->getResponse();

        self::assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
