<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Exception\Repository;

use App\Exceptions\AbstractHttpException;
use Symfony\Component\HttpFoundation\Response;

class EntityNotFoundException extends AbstractHttpException
{
    public function __construct(int $reviewId)
    {
        parent::__construct(
            Response::HTTP_NOT_FOUND,
            sprintf('Review id: %s', $reviewId)
        );
    }
}
