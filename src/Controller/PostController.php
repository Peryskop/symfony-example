<?php

declare(strict_types=1);

namespace App\Controller;

use App\Attribute\MapToDTO;
use App\DTO\Post\PostDTO;
use App\DTO\Transformer\ResponseDTOTransformerInterface;
use App\Entity\Post;
use App\Factory\Entity\CompositeEntityFactoryInterface;
use App\Paginator\Paginator;
use App\Repository\PostRepository;
use App\Updater\Entity\CompositeEntityUpdaterInterface;
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
        private readonly CompositeEntityUpdaterInterface $updater,
        private readonly CompositeEntityFactoryInterface $factory,
        private readonly ResponseDTOTransformerInterface $responseDTOTransformer
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

        $dtos = $this->responseDTOTransformer->transformFromObjects($paginator);
        $paginatedResponse = $this->paginator->createPaginatedResponse($dtos, $paginator);

        return $this->respond(
            $paginatedResponse,
            ['post:read', 'user:read']
        );
    }

    #[Route('posts/{id}', name: 'show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        $dto = $this->responseDTOTransformer->transformFromObject($post);

        return $this->respond(
            $dto,
            ['post:read', 'user:read']
        );
    }

    #[Route('posts', name: 'create', methods: ['POST'])]
    public function create(#[MapToDTO] PostDTO $postDTO): Response
    {
        $this->multiFieldValidator->validate($postDTO, ['default']);

        $post = $this->factory->create($postDTO);

        $this->postRepository->save($post);

        $dto = $this->responseDTOTransformer->transformFromObject($post);

        return $this->respond(
            $dto,
            ['post:read', 'user:read'],
            Response::HTTP_CREATED
        );
    }

    #[Route('posts/{id}', name: 'update', methods: ['PUT'])]
    public function update(#[MapToDTO] PostDTO $postDTO, Post $post): Response
    {
        $this->multiFieldValidator->validate($postDTO, ['default']);

        $this->updater->update($post, $postDTO);

        $this->postRepository->flush();

        $dto = $this->responseDTOTransformer->transformFromObject($post);

        return $this->respond(
            $dto,
            ['post:read', 'user:read']
        );
    }

    #[Route('posts/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Post $post): Response
    {
        $this->postRepository->delete($post);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
