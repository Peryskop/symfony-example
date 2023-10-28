<?php

declare(strict_types=1);

namespace App\Controller;

use App\Attribute\MapToDTO;
use App\DTO\Comment\CommentDTO;
use App\DTO\Transformer\ResponseDTOTransformerInterface;
use App\Entity\Comment;
use App\Entity\Post;
use App\Factory\Entity\CompositeEntityFactoryInterface;
use App\Paginator\Paginator;
use App\Paginator\PaginatorInterface;
use App\Repository\CommentRepositoryInterface;
use App\Updater\Entity\CompositeEntityUpdaterInterface;
use App\Validator\MultiFieldValidatorInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'comments_')]
final class CommentController extends AbstractApiController
{
    public function __construct(
        readonly SerializerInterface $serializer,
        private readonly MultiFieldValidatorInterface $multiFieldValidator,
        private readonly PaginatorInterface $paginator,
        private readonly CommentRepositoryInterface $commentRepository,
        private readonly CompositeEntityUpdaterInterface $updater,
        private readonly CompositeEntityFactoryInterface $factory,
        private readonly ResponseDTOTransformerInterface $responseDTOTransformer
    ) {
        parent::__construct($serializer);
    }

    #[Route('posts/{post}/comments', name: 'index', methods: ['GET'])]
    public function index(Post $post, Request $request): Response
    {
        $queryBuilder = $this->commentRepository->findByPost($request->query->all(), $post);

        $paginator = $this->paginator->createPaginator(
            $queryBuilder,
            (int) $request->get('page', Paginator::PAGINATOR_DEFAULT_PAGE),
            (int) $request->get('limit', Paginator::PAGINATOR_DEFAULT_LIMIT)
        );

        $dtos = $this->responseDTOTransformer->transformFromObjects($paginator);
        $paginatedResponse = $this->paginator->createPaginatedResponse($dtos, $paginator);

        return $this->respond(
            $paginatedResponse,
            ['comment:read', 'user:read']
        );
    }

    #[Route('posts/{post}/comments/{comment?null}', name: 'create', methods: ['POST'])]
    public function create(#[MapToDTO] CommentDTO $commentDTO): Response
    {
        $this->multiFieldValidator->validate($commentDTO, ['default']);

        $comment = $this->factory->create($commentDTO);

        $this->commentRepository->save($comment);

        $dto = $this->responseDTOTransformer->transformFromObject($comment);

        return $this->respond(
            $dto,
            ['comment:read', 'user:read'],
            Response::HTTP_CREATED
        );
    }

    #[Route('posts/{post}/comments/{comment}', name: 'update', methods: ['PUT'])]
    public function update(#[MapToDTO] CommentDTO $commentDTO, Comment $comment): Response
    {
        $this->multiFieldValidator->validate($commentDTO, ['default']);

        $this->updater->update($comment, $commentDTO);

        $this->commentRepository->flush();

        $dto = $this->responseDTOTransformer->transformFromObject($comment);

        return $this->respond(
            $dto,
            ['comment:read', 'user:read']
        );
    }

    #[Route('posts/{post}/comments/{comment}', name: 'delete', methods: ['DELETE'])]
    public function delete(Comment $comment): Response
    {
        $this->commentRepository->delete($comment);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
