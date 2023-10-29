<?php

declare(strict_types=1);

namespace App\Tests\Post;

use ApiTestCase\JsonApiTestCase;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;

final class DeleteTest extends JsonApiTestCase
{
    private object $postRepository;

    private object $userRepository;

    protected function setUp(): void
    {
        $this->loadFixturesFromFiles(['post.yaml', 'user.yaml', 'comment.yaml']);
        $this->postRepository = static::getContainer()->get(PostRepository::class);
        $this->userRepository = static::getContainer()->get(UserRepository::class);
        $this->client->loginUser($this->userRepository->findOneBy(['email' => 'existing.user@email.com']));
    }

    public function testDeletePostSuccess(): void
    {
        $post = $this->postRepository->findOneBy(['description' => 'test description 1']);

        $this->client->request(
            method: 'DELETE',
            uri: sprintf('/api/posts/%d', $post->getId()),
            server:
            [
                'CONTENT_TYPE' => 'application/json',
            ]
        );

        $response = $this->client->getResponse();

        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);
    }

    public function testDeletePostByAdminSuccess(): void
    {
        $this->client->loginUser($this->userRepository->findOneBy(['email' => 'existing.user@email.com']));

        $post = $this->postRepository->findOneBy(['description' => 'test description 1']);

        $this->client->request(
            method: 'DELETE',
            uri: sprintf('/api/posts/%d', $post->getId()),
            server:
            [
                'CONTENT_TYPE' => 'application/json',
            ]
        );

        $response = $this->client->getResponse();

        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);
    }

    public function testDeletePostAccessDenied(): void
    {
        $post = $this->postRepository->findOneBy(['description' => 'test description 2']);

        $this->client->request(
            method: 'DELETE',
            uri: sprintf('/api/posts/%d', $post->getId()),
            server:
            [
                'CONTENT_TYPE' => 'application/json',
            ]
        );

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Shared/access_denied',Response::HTTP_FORBIDDEN);
    }

    public function testDeletePostByAdminAccessDenied(): void
    {
        $post = $this->postRepository->findOneBy(['description' => 'test description 2']);

        $this->client->request(
            method: 'DELETE',
            uri: sprintf('/api/admin/posts/%d', $post->getId()),
            server:
            [
                'CONTENT_TYPE' => 'application/json',
            ]
        );

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Shared/access_denied',Response::HTTP_FORBIDDEN);
    }
}
