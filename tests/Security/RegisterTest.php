<?php

declare(strict_types=1);

namespace App\Tests\Security;

use ApiTestCase\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

final class RegisterTest extends JsonApiTestCase
{
    protected function setUp(): void
    {
        $this->loadFixturesFromFiles(['user.yaml']);
    }

    public function testRegisterMissingAllData(): void
    {
        $this->client->request(method: 'POST', uri: '/api/register');

        $this->assertResponse(
            $this->client->getResponse(),
            'Security/missing_all_data',
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    public function testRegisterInvalidEmail(): void
    {
        $this->client->request(
            method: 'POST',
            uri: '/api/register',
            content:
            '{
                "email": "test5@email",
                "password": "zaq1@WSX",
                "firstName": "John",
                "lastName": "Doe"
            }'
        );

        $this->assertResponse(
            $this->client->getResponse(),
            'Security/invalid_email',
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    public function testRegisterInvalidPassword(): void
    {
        $this->client->request(
            method: 'POST',
            uri: '/api/register',
            content:
            '{
                "email": "test5@email.com",
                "password": "zaq",
                "firstName": "John",
                "lastName": "Doe"
            }'
        );

        $this->assertResponse(
            $this->client->getResponse(),
            'Security/invalid_password',
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    public function testRegisterSuccess(): void
    {
        $this->client->request(
            method: 'POST',
            uri: '/api/register',
            content:
            '{
                "email": "test@email.com",
                "password": "zaq1@WSX",
                "firstName": "John",
                "lastName": "Doe"
            }'
        );

        $this->assertResponse(
            $this->client->getResponse(),
            'Security/register_success',
            Response::HTTP_CREATED
        );
    }

    public function testRegisterEmailInUse(): void
    {
        $this->client->request(
            method: 'POST',
            uri: '/api/register',
            content:
            '{
                "email": "existing.user@email.com",
                "password": "zaq1@WSX",
                "firstName": "John",
                "lastName": "Doe"
            }'
        );

        $this->assertResponse(
            $this->client->getResponse(),
            'Security/email_in_use',
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
