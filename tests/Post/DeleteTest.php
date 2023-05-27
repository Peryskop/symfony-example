<?php

declare(strict_types=1);

namespace App\Tests\Post;

use ApiTestCase\JsonApiTestCase;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;

final class DeleteTest extends JsonApiTestCase
{
    private object $postRepository;

    protected function setUp(): void
    {
        $this->loadFixturesFromFiles(['post.yaml']);
        $this->postRepository = static::getContainer()->get(PostRepository::class);
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
}
