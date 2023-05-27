<?php

declare(strict_types=1);

namespace App\Tests\Post;

use ApiTestCase\JsonApiTestCase;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;

final class UpdateTest extends JsonApiTestCase
{
    private object $postRepository;

    protected function setUp(): void
    {
        $this->loadFixturesFromFiles(['post.yaml']);
        $this->postRepository = static::getContainer()->get(PostRepository::class);
    }

    public function testUpdatePostSuccess(): void
    {
        $post = $this->postRepository->findOneBy(['description' => 'test description 1']);

        $this->client->request(
            method: 'PUT',
            uri: sprintf('/api/posts/%d', $post->getId()),
            server:
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            content:
            '{
                "description": "Lorem ipsum updated"
            }'
        );

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Post/update_success', Response::HTTP_OK);
    }

    public function testUpdatePostMissingAllData(): void
    {
        $post = $this->postRepository->findOneBy(['description' => 'test description 1']);

        $this->client->request(
            method: 'PUT',
            uri: sprintf('/api/posts/%d', $post->getId()),
            server:
            [
                'CONTENT_TYPE' => 'application/json',
            ]
        );

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Post/missing_all_data', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testUpdatePostTooLongDescription(): void
    {
        $post = $this->postRepository->findOneBy(['description' => 'test description 1']);

        $this->client->request(
            method: 'PUT',
            uri: sprintf('/api/posts/%d', $post->getId()),
            server:
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            content:
            '{
                "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec molestie malesuada elementum. Morbi et efficitur est. Curabitur semper, ligula tristique pretium mattis, tortor sapien tristique lacus, sed vestibulum libero diam in massa. Ut posuere augue risus, accumsan euismod est dapibus vitae. Sed congue, quam pellentesque viverra placerat, magna dolor congue libero, at iaculis mauris est quis magna. Fusce nunc felis, tristique at massa a, aliquam lobortis lectus. Sed nec iaculis erat, ac ultrices velit. Fusce sem libero, tempus a ex quis, sodales mollis ligula. Nullam non suscipit justo, non volutpat tortor. Nunc volutpat lacus ut est blandit aliquam. Cras sollicitudin augue eu tortor ullamcorper luctus. Morbi rutrum, odio sed varius scelerisque, ante leo mattis diam, sed finibus orci enim id nisl. Nunc ultricies lorem odio. Donec eget nisi varius, vestibulum odio vel, facilisis dolor. Praesent commodo cursus dui, ornare pellentesque enim dignissim sed. Curabitur at ex maximus, condimentum augue sed, ullamcorper purus. Proin feugiat id risus et rutrum. Quisque nibh leo, feugiat eu enim ac, dapibus interdum leo. Quisque volutpat tristique augue, porttitor tincidunt diam rhoncus eu. Donec laoreet, nulla sit amet mollis rhoncus, mauris lacus cursus magna, ut posuere ex mi ac metus. Duis quis dignissim mauris. Vestibulum euismod facilisis enim, sed aliquam tellus sodales ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Integer a arcu eget felis iaculis accumsan. Proin auctor nunc id nibh rutrum aliquam. Maecenas laoreet purus vel purus porttitor, faucibus pulvinar eros elementum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus lorem augue, cursus id augue sit amet, cursus accumsan ex. Sed id odio aliquam, commodo sem ac, egestas augue. Nullam dignissim ornare eros vitae porttitor. Mauris tincidunt massa sed volutpat semper. Nulla maximus eros ligula, ut congue risus eleifend ut. Vivamus massa felis, ornare sit amet eros pharetra, vulputate ullamcorper arcu. Nunc lorem est, interdum vel sollicitudin et, scelerisque nec diam. Curabitur imperdiet, ligula at convallis feugiat, ipsum risus tristique lorem, id molestie leo dolor in nisi."
            }'
        );

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'Post/too_long_description', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
