<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Validator\StoreReviewValidatorFactory;
use App\Http\Validator\UpdateReviewValidatorFactory;
use App\Modules\Reviews\Domain\Repository\ReviewRepositoryInterface;
use App\Modules\Reviews\Domain\Service\ReviewService;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Response;
use function response;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServerRequestInterface $request - Request object with input data:
     *   $request->getParsedBody()['content'] - Textual content of review
     *   $request->getParsedBody()['userId'] - Unique identifier of review author
     *   $request->getParsedBody()['applicationId'] - Unique identifier of application where review was made
     *
     * @return Response
     */
    public function store(ServerRequestInterface $request): Response
    {
        $data = $request->getParsedBody();
        $validator = StoreReviewValidatorFactory::create($data);

        if ($validator->fails()) {
            return response()
                ->json($validator->errors())
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $review = app(ReviewService::class)->createReview(
            $data['content'],
            (int) $data['userId'], // todo get from jwt
            (int) $data['applicationId'],
        );

        return response()
            ->json($review)
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id - Unique identifier of review
     *
     * @return Response
     */
    public function show(int $id): Response
    {
        $review = app(ReviewRepositoryInterface::class)->findOrFail($id);

        return response()
            ->json($review)
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id - Unique identifier of review
     * @param ServerRequestInterface $request - Request object with input data:
     *   $request->getParsedBody()['content'] - Textual content of review
     *
     * @return Response
     */
    public function update(int $id, ServerRequestInterface $request): Response
    {
        $data = $request->getParsedBody();
        $validator = UpdateReviewValidatorFactory::create($data);

        if ($validator->fails()) {
            return response()
                ->json($validator->errors())
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        app(ReviewService::class)->updateReviewContent(
            $id,
            $data['content'],
        );

        return response()
            ->json()
            ->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id - Unique identifier of review
     *
     * @return Response
     */
    public function destroy(int $id): Response
    {
        app(ReviewService::class)->removeReview($id);

        return response()
            ->json()
            ->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
