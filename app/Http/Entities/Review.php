<?php

declare(strict_types=1);

namespace App\Http\Entities;

use App\Modules\Reviews\Domain\Entities\Review as DomainReview;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "ReviewResponse",
)]
class Review
{
    public function __construct(
        #[OA\Property()]
        public int $id,
        #[OA\Property()]
        public string $content,
        #[OA\Property()]
        public string $status,
        #[OA\Property()]
        public int $userId,
        #[OA\Property()]
        public int $applicationId,
        #[OA\Property()]
        public string $createdAt,
        #[OA\Property()]
        public int $version
    ) {
    }

    public static function fromDomain(DomainReview $review): self
    {
        return new self(
            $review->getId()->getValue(),
            $review->getContent()->getValue(),
            $review->getStatus()->getValue(),
            $review->getUserId()->getValue(),
            $review->getApplicationId()->getValue(),
            $review->getCreatedAt()->getValue(),
            $review->getVersion(),
        );
    }
}
