<?php

declare(strict_types=1);

namespace App\Tests\Security;

use ApiTestCase\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

final class LoginTest extends JsonApiTestCase
{
    public function testLoginSuccess(): void
    {
        $this->loadFixturesFromFiles(['user.yaml']);
        $this->client->request(
            method: 'POST',
            uri: '/api/login',
            server: ['CONTENT_TYPE' => 'application/json'],
            content:
            '{
                "email": "existing.user@email.com",
                "password": "zaq1@WSX"
            }'
        );

        $this->assertResponseCode(
            $this->client->getResponse(),
            Response::HTTP_NO_CONTENT
        );
    }

    public function testLoginFailure(): void
    {
        $this->client->request(
            method: 'POST',
            uri: '/api/login',
            server: ['CONTENT_TYPE' => 'application/json'],
            content:
            '{
                "email": "invalid@email.com",
                "password": "invalidPassword"
            }'
        );

        $this->assertResponse(
            $this->client->getResponse(),
            'Security/login_failure',
            Response::HTTP_UNAUTHORIZED
        );
    }
}
