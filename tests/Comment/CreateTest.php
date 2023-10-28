<?php

declare(strict_types=1);

namespace App\Tests\Comment;

use ApiTestCase\JsonApiTestCase;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;

final class CreateTest extends JsonApiTestCase
{
    private object $userRepository;

    private object $postRepository;

    private object $commentRepository;

    protected function setUp(): void
    {
        $this->loadFixturesFromFiles(['post.yaml', 'user.yaml', 'comment.yaml']);
        $this->userRepository = static::getContainer()->get(UserRepository::class);
        $this->postRepository = static::getContainer()->get(PostRepository::class);
        $this->commentRepository = static::getContainer()->get(CommentRepository::class);
        $this->client->loginUser($this->userRepository->findOneBy(['email' => 'existing.user@email.com']));
    }

    public function testCreateCommentSuccess(): void
    {
        $post = $this->postRepository->findOneBy(['description' => 'test description 1']);

        $this->client->request(
            method: 'POST',
            uri: sprintf('/api/posts/%d/comments', $post->getId()),
            server:
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            content:
            '{
                "content": "Hello world"
            }'
        );

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Comment/create_success', Response::HTTP_CREATED);
    }

    public function testCreateCommentToCommentSuccess(): void
    {
        $post = $this->postRepository->findOneBy(['description' => 'test description 1']);
        $comment = $this->commentRepository->findOneBy(['content' => 'test content 1']);

        $this->client->request(
            method: 'POST',
            uri: sprintf('/api/posts/%d/comments/%d', $post->getId(), $comment->getId()),
            server:
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            content:
            '{
                "content": "Hello world"
            }'
        );

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Comment/create_success', Response::HTTP_CREATED);
    }

    public function testCreateCommentMissingAllData(): void
    {
        $post = $this->postRepository->findOneBy(['description' => 'test description 1']);

        $this->client->request(
            method: 'POST',
            uri: sprintf('/api/posts/%d/comments', $post->getId()),
            server:
            [
                'CONTENT_TYPE' => 'application/json',
            ]
        );

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Comment/missing_all_data', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCreateCommentTooLongDescription(): void
    {
        $post = $this->postRepository->findOneBy(['description' => 'test description 1']);

        $this->client->request(
            method: 'POST',
            uri: sprintf('/api/posts/%d/comments', $post->getId()),
            server:
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            content:
            '{
                "content": "HOTaJ55H4TeB50lXC60iCrMMDph6GVbXM3AQ60v7F6Xu0DqIkEWRYNKeJSlKR5YXfK7JDWOfCl4a3WOwUAz9KAIfDH3tuNW30BtRP4d9VKBvzSJ4ZEF5ZQgBhUhLCzSzfQeuDSvqDDXV64URKr7qpb2aqlBAKGv7YD23tahoSJO8DuEiJ5fk2vQ5lcLyJZ2XkpWnt0fhtJylJBXYLpOcSSmFHJjnhvkKjCGWSznANvzLXzkvHQMcOIRajFtA5A9DrKfbCZcsedJ7gMFxAytl67uZ0vfpX1SfTxnVFxFNf6Ungw3r1mMyaFfXwBPCyob9Q01n0CUxKTyEfDPmCfKtLvHvkDiV3w0WVEilLbg52Y0HSffyCKzmP5mbaQAjiirEhVAI1tWCyShEFKQxYoO9AeuEgsCxgCwV5yg1EFVnAiJqzD6tOVVWX9WjkUsS5brjDZOh5tlyU1b804nkbMN1UqRiJ76Il5f2cvWuChzLW0qMZBEKruzN5"
            }'
        );

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Comment/too_long_content', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
