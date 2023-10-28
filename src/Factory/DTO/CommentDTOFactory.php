<?php

declare(strict_types=1);

namespace App\Factory\DTO;

use App\DTO\Comment\CommentDTO;
use App\DTO\DTOInterface;
use Symfony\Component\HttpFoundation\Request;

final class CommentDTOFactory implements DTOFactoryInterface
{
    public function create(Request $request): DTOInterface
    {
        $data = json_decode((string) $request->getContent(), true);
        $data['postId'] = is_numeric($request->get('post')) ? (int) $request->get('post') : null;
        $data['commentId'] = is_numeric($request->get('comment')) ? (int) $request->get('comment') : null;
        return new CommentDTO($data);
    }

    public function supports(DTOInterface $DTO): bool
    {
        return $DTO::class === CommentDTO::class;
    }
}
