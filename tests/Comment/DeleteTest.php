<?php

declare(strict_types=1);

namespace App\Tests\Comment;

use ApiTestCase\JsonApiTestCase;
use App\Repository\CommentRepository;
use App\Repository\CommentRepositoryInterface;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;

final class DeleteTest extends JsonApiTestCase
{
    private object $postRepository;

    private object $commentRepository;

    private object $userRepository;

    protected function setUp(): void
    {
        $this->loadFixturesFromFiles(['post.yaml', 'user.yaml', 'comment.yaml']);
        $this->postRepository = static::getContainer()->get(PostRepository::class);
        $this->commentRepository = static::getContainer()->get(CommentRepository::class);
        $this->userRepository = static::getContainer()->get(UserRepository::class);
        $this->client->loginUser($this->userRepository->findOneBy(['email' => 'existing.user@email.com']));
    }

    public function testDeleteCommentSuccess(): void
    {
        $post = $this->postRepository->findOneBy(['description' => 'test description 1']);
        $comment = $this->commentRepository->findOneBy(['content' => 'test content 1']);

        $this->client->request(
            method: 'DELETE',
            uri: sprintf('/api/posts/%d/comments/%d', $post->getId(), $comment->getId()),
            server:
            [
                'CONTENT_TYPE' => 'application/json',
            ]
        );

        $response = $this->client->getResponse();

        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);
    }

    public function testDeleteCommentByAdminSuccess(): void
    {
        $this->client->loginUser($this->userRepository->findOneBy(['email' => 'admin@email.com']));

        $post = $this->postRepository->findOneBy(['description' => 'test description 1']);
        $comment = $this->commentRepository->findOneBy(['content' => 'test content 1']);

        $this->client->request(
            method: 'DELETE',
            uri: sprintf('/api/admin/posts/%d/comments/%d', $post->getId(), $comment->getId()),
            server:
            [
                'CONTENT_TYPE' => 'application/json',
            ]
        );

        $response = $this->client->getResponse();

        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);
    }

    public function testDeleteCommentAccessDenied(): void
    {
        $post = $this->postRepository->findOneBy(['description' => 'test description 1']);
        $comment = $this->commentRepository->findOneBy(['content' => 'test content 2']);

        $this->client->request(
            method: 'DELETE',
            uri: sprintf('/api/posts/%d/comments/%d', $post->getId(), $comment->getId()),
            server:
            [
                'CONTENT_TYPE' => 'application/json',
            ]
        );

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Shared/access_denied', Response::HTTP_FORBIDDEN);
    }

    public function testDeleteCommentByAdminAccessDenied(): void
    {
        $post = $this->postRepository->findOneBy(['description' => 'test description 1']);
        $comment = $this->commentRepository->findOneBy(['content' => 'test content 1']);

        $this->client->request(
            method: 'DELETE',
            uri: sprintf('/api/admin/posts/%d/comments/%d', $post->getId(), $comment->getId()),
            server:
            [
                'CONTENT_TYPE' => 'application/json',
            ]
        );

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Shared/access_denied', Response::HTTP_FORBIDDEN);
    }
}
