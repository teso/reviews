<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Entities\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Validator\CreateReviewValidatorFactory;
use App\Http\Validator\UpdateReviewValidatorFactory;
use App\Modules\Reviews\Application\CommandHandlers\CreateReviewHandler;
use App\Modules\Reviews\Application\CommandHandlers\RemoveReviewHandler;
use App\Modules\Reviews\Application\CommandHandlers\UpdateReviewContentHandler;
use App\Modules\Reviews\Application\Commands\CreateReview;
use App\Modules\Reviews\Application\Commands\RemoveReview;
use App\Modules\Reviews\Application\Commands\UpdateReviewContent;
use App\Modules\Reviews\Application\Queries\GetReview;
use App\Modules\Reviews\Application\QueryHandlers\GetReviewHandler;
use App\Modules\Reviews\Domain\DomainConfig;
use App\Modules\Reviews\Domain\Exceptions\Repository\EntityNotFoundException;
use Doctrine\ORM\OptimisticLockException;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Response;
use function response;

class ReviewController extends Controller
{
    #[OA\Get(
        path: '/api/reviews/{id}',
        description: 'Get a single review by ID',
        operationId: 'getReview',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'Unique identifier of review',
                required: true,
                schema: new OA\Schema(type: 'integer', minimum: 1),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Returns the found review',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ReviewResponse'
                ),
            ),
            new OA\Response(
                response: 404,
                description: 'The review was not found',
            ),
        ],
    )]
    public function get(int $id): Response
    {
        $handler = app(GetReviewHandler::class);

        $review = $handler(new GetReview($id));

        if (!$review) {
            return response(status: Response::HTTP_NOT_FOUND);
        }

        return response()
            ->json(Review::fromDomain($review))
            ->setStatusCode(Response::HTTP_OK);
    }

    #[OA\Post(
        path: '/api/reviews',
        description: 'Create a new review',
        operationId: 'createReview',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'application/x-www-form-urlencoded',
                schema: new OA\Schema(
                    type: 'object',
                    required: ['content', 'userId', 'applicationId'],
                    properties: [
                        new OA\Property(
                            property: 'content',
                            type: 'string',
                            minLength: DomainConfig::MIN_CONTENT_LENGTH,
                            maxLength: DomainConfig::MAX_CONTENT_LENGTH,
                            description: 'Textual content of review'
                        ),
                        new OA\Property(
                            property: 'userId',
                            type: 'integer',
                            minimum: 1,
                            description: 'Unique identifier of review author'
                        ),
                        new OA\Property(
                            property: 'applicationId',
                            type: 'integer',
                            minimum: 1,
                            description: 'Unique identifier of application where review was made'
                        ),
                    ],
                )
            ),
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Returns the created review',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ReviewResponse'
                ),
            ),
            new OA\Response(
                response: 400,
                description: 'Returns a list of validation error',
                content: new OA\JsonContent(
                    type: 'object',
                    additionalProperties: new OA\AdditionalProperties(
                        type: 'array',
                        items: new OA\Items(type: 'string')
                    ),
                )
            ),
        ],
    )]
    public function create(ServerRequestInterface $request): Response
    {
        $data = $request->getParsedBody();
        $validator = CreateReviewValidatorFactory::create($data);

        if ($validator->fails()) {
            return response()
                ->json($validator->errors())
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $handler = app(CreateReviewHandler::class);

        $review = $handler(new CreateReview(
            $data['content'],
            (int) $data['userId'], // todo use current user id
            (int) $data['applicationId'],
        ));

        return response()
            ->json(Review::fromDomain($review))
            ->setStatusCode(Response::HTTP_CREATED);
    }

    #[OA\Put(
        path: '/api/reviews/{id}',
        description: 'Update a single review by ID',
        operationId: 'updateReview',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'Unique identifier of review',
                required: true,
                schema: new OA\Schema(type: 'integer', minimum: 1),
            ),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'application/x-www-form-urlencoded',
                schema: new OA\Schema(
                    type: 'object',
                    required: ['content', 'version'],
                    properties: [
                        new OA\Property(
                            property: 'content',
                            type: 'string',
                            minLength: DomainConfig::MIN_CONTENT_LENGTH,
                            maxLength: DomainConfig::MAX_CONTENT_LENGTH,
                            description: 'New textual content of review that should be changed'
                        ),
                        new OA\Property(
                            property: 'version',
                            type: 'integer',
                            minimum: 1,
                            description: 'Version of entity'
                        )
                    ],
                )
            ),
        ),
        responses: [
            new OA\Response(
                response: 204,
                description: 'The review was updated successfully',
            ),
            new OA\Response(
                response: 400,
                description: 'Returns a list of validation error',
                content: new OA\JsonContent(
                    type: 'object',
                    additionalProperties: new OA\AdditionalProperties(
                        type: 'array',
                        items: new OA\Items(type: 'string')
                    ),
                )
            ),
            new OA\Response(
                response: 404,
                description: 'The review was not found',
            ),
            new OA\Response(
                response: 409,
                description: 'The review was updated by someone else',
            ),
        ],
    )]
    public function update(int $id, ServerRequestInterface $request): Response
    {
        $data = $request->getParsedBody();
        $validator = UpdateReviewValidatorFactory::create($data);

        if ($validator->fails()) {
            return response()
                ->json($validator->errors())
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        try {
            $handler = app(UpdateReviewContentHandler::class);

            $handler(new UpdateReviewContent(
                $id,
                $data['content'],
                (int) $data['version'],
            ));
        } catch (EntityNotFoundException) {
            return response(status: Response::HTTP_NOT_FOUND);
        } catch (OptimisticLockException) {
            return response(status: Response::HTTP_CONFLICT);
        }

        return response(status: Response::HTTP_NO_CONTENT);
    }

    #[OA\Delete(
        path: '/api/reviews/{id}',
        description: 'Remove a single review by ID',
        operationId: 'removeReview',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'Unique identifier of review',
                required: true,
                schema: new OA\Schema(type: 'integer', minimum: 1),
            ),
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'The review was removed successfully',
            ),
            new OA\Response(
                response: 404,
                description: 'The review was not found',
            ),
        ],
    )]
    public function remove(int $id): Response
    {
        try {
            $handler = app(RemoveReviewHandler::class);

            $handler(new RemoveReview($id));
        } catch (EntityNotFoundException) {
            return response(status: Response::HTTP_NOT_FOUND);
        }

        return response(status: Response::HTTP_NO_CONTENT);
    }
}
