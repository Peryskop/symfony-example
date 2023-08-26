<?php

declare(strict_types=1);

namespace App\Controller;

use App\Attribute\MapToDTO;
use App\DTO\Post\PostDTO;
use App\DTO\Transformer\PostResponseDTOTransformer;
use App\Entity\Post;
use App\Factory\PostFactory;
use App\Paginator\Paginator;
use App\Repository\PostRepository;
use App\Updater\PostUpdater;
use App\Validator\MultiFieldValidator;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'posts_')]
final class PostController extends AbstractApiController
{
    public function __construct(
        readonly SerializerInterface $serializer,
        private readonly MultiFieldValidator $multiFieldValidator,
        private readonly Paginator $paginator,
        private readonly PostRepository $postRepository,
        private readonly PostUpdater $postUpdater,
        private readonly PostFactory $postFactory,
        private readonly PostResponseDTOTransformer $postResponseDTOTransformer
    ) {
        parent::__construct($serializer);
    }

    #[Route('posts', name: 'index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $queryBuilder = $this->postRepository->findByParams($request->query->all());

        $paginator = $this->paginator->createPaginator(
            $queryBuilder,
            (int) $request->get('page', Paginator::PAGINATOR_DEFAULT_PAGE),
            (int) $request->get('limit', Paginator::PAGINATOR_DEFAULT_LIMIT)
        );

        $dtos = $this->postResponseDTOTransformer->transformFromObjects($paginator);
        $paginatedResponse = $this->paginator->createPaginatedResponse($dtos, $paginator);

        return $this->respond(
            $paginatedResponse,
            ['post:read']
        );
    }

    #[Route('posts/{id}', name: 'show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        $dto = $this->postResponseDTOTransformer->transformFromObject($post);

        return $this->respond(
            $dto,
            ['post:read']
        );
    }

    #[Route('posts', name: 'create', methods: ['POST'])]
    public function create(#[MapToDTO] PostDTO $postDTO): Response
    {
        $this->multiFieldValidator->validate($postDTO, ['default']);

        $post = $this->postFactory->createFromDTO($postDTO);

        $this->postRepository->save($post);

        $dto = $this->postResponseDTOTransformer->transformFromObject($post);

        return $this->respond(
            $dto,
            ['post:read'],
            Response::HTTP_CREATED
        );
    }

    #[Route('posts/{id}', name: 'update', methods: ['PUT'])]
    public function update(#[MapToDTO] PostDTO $postDTO, Post $post): Response
    {
        $this->multiFieldValidator->validate($postDTO, ['default']);

        $this->postUpdater->update($post, $postDTO);

        $this->postRepository->flush();

        $dto = $this->postResponseDTOTransformer->transformFromObject($post);

        return $this->respond(
            $dto,
            ['post:read']
        );
    }

    #[Route('posts/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Post $post): Response
    {
        $this->postRepository->delete($post);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
