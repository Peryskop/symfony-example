<?php

declare(strict_types=1);

namespace App\Tests\User;

use ApiTestCase\JsonApiTestCase;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;

final class UpdateTest extends JsonApiTestCase
{
    private object $userRepository;

    protected function setUp(): void
    {
        $this->loadFixturesFromFiles(['user.yaml']);
        $this->userRepository = static::getContainer()->get(UserRepository::class);
        $this->client->loginUser($this->userRepository->findOneBy(['email' => 'existing.user@email.com']));
    }

    public function testUpdateCurrentUserSuccess(): void
    {
        $this->client->request(
            method: 'PATCH',
            uri: '/api/users/current',
            content:'
             {
                "firstName": "John updated",
                "lastName": "Doe updated"
            }
            '
        );

        $this->assertResponse(
            $this->client->getResponse(),
            'User/current_user_update_success',
            Response::HTTP_OK
        );
    }

    public function testUpdateCurrentUserMissingAllData(): void
    {
        $this->client->request(
            method: 'PATCH',
            uri: '/api/users/current'
        );

        $this->assertResponse(
            $this->client->getResponse(),
            'User/current_user_update_missing_all_data',
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
