<?php

declare(strict_types=1);

namespace App\Controller;

use App\Attribute\MapToDTO;
use App\DTO\Post\PostDTO;
use App\DTO\Transformer\ResponseDTOTransformerInterface;
use App\Entity\Post;
use App\Entity\PostInterface;
use App\Factory\Entity\CompositeEntityFactoryInterface;
use App\Paginator\Paginator;
use App\Paginator\PaginatorInterface;
use App\Remover\Entity\CompositeEntityRemoverInterface;
use App\Repository\PostRepositoryInterface;
use App\Updater\Entity\CompositeEntityUpdaterInterface;
use App\Validator\MultiFieldValidatorInterface;
use App\Voter\PostVoter;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'posts_')]
final class PostController extends AbstractApiController
{
    public function __construct(
        readonly SerializerInterface $serializer,
        private readonly MultiFieldValidatorInterface $multiFieldValidator,
        private readonly PaginatorInterface $paginator,
        private readonly PostRepositoryInterface $postRepository,
        private readonly CompositeEntityUpdaterInterface $updater,
        private readonly CompositeEntityFactoryInterface $factory,
        private readonly ResponseDTOTransformerInterface $responseDTOTransformer,
        private readonly CompositeEntityRemoverInterface $remover
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

        return $this->respond(
            $this->paginator->createPaginatedResponse($dtos, $paginator),
            ['post:read', 'user:read']
        );
    }

    #[Route('posts/{id}', name: 'show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->respond(
            $this->responseDTOTransformer->transformFromObject($post),
            ['post:read', 'user:read']
        );
    }

    #[Route('posts', name: 'create', methods: ['POST'])]
    public function create(#[MapToDTO] PostDTO $postDTO): Response
    {
        $this->multiFieldValidator->validate($postDTO, ['default']);

        /** @var PostInterface $post */
        $post = $this->factory->create($postDTO);

        $this->postRepository->save($post);

        return $this->respond(
            $this->responseDTOTransformer->transformFromObject($post),
            ['post:read', 'user:read'],
            Response::HTTP_CREATED
        );
    }

    #[Route('posts/{id}', name: 'update', methods: ['PUT'])]
    public function update(#[MapToDTO] PostDTO $postDTO, Post $post): Response
    {
        $this->denyAccessUnlessGranted(PostVoter::EDIT, $post);

        $this->multiFieldValidator->validate($postDTO, ['default']);

        $this->updater->update($post, $postDTO);

        $this->postRepository->flush();

        return $this->respond(
            $this->responseDTOTransformer->transformFromObject($post),
            ['post:read', 'user:read']
        );
    }

    #[Route('posts/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Post $post): Response
    {
        $this->denyAccessUnlessGranted(PostVoter::DELETE, $post);

        $this->remover->softDelete($post);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('admin/posts/{id}', name: 'delete_admin', methods: ['DELETE'])]
    public function deleteAdmin(Post $post): Response
    {
        $this->remover->softDelete($post);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
