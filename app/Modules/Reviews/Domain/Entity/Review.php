<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Entity;

use App\Modules\Reviews\Domain\Event\CreateReviewEvent;
use App\Modules\Reviews\Domain\Event\ReviewAcceptedEvent;
use App\Modules\Reviews\Domain\Event\ReviewContentUpdatedEvent;
use App\Modules\Reviews\Domain\Event\ReviewRejectedEvent;
use App\Modules\Reviews\Domain\ValueObject\ContentValue;
use App\Modules\Reviews\Domain\ValueObject\DatetimeValue;
use App\Modules\Reviews\Domain\ValueObject\IntegerIdValue;
use App\Modules\Reviews\Domain\ValueObject\ReviewStatusEnum;

class Review implements AggregateRootInterface
{
    use AggregateRootTrait;
    use EntityTrait;

    private $content;
    private $status;
    private $userId;
    private $applicationId;
    private $createdAt;

    public static function createReview(
        string $content,
        int $userId,
        int $applicationId
    ) {
        $review = new self(
            $content,
            ReviewStatusEnum::PENDING_MODERATION,
            $userId,
            $applicationId,
            date('Y-m-d H:i:s')
        );

        $review->pushDomainEvent(new CreateReviewEvent($review));
    }

    public function __construct(
        string $content,
        string $status,
        int $userId,
        int $applicationId,
        string $createdAt
    ) {
        $this->content = new ContentValue($content);
        $this->status = new ReviewStatusEnum($status);
        $this->userId = new IntegerIdValue($userId);
        $this->applicationId = new IntegerIdValue($applicationId);
        $this->createdAt = new DatetimeValue($createdAt);
    }

    public function accept(): void
    {
        $this->status = new ReviewStatusEnum(ReviewStatusEnum::ACCEPTED);

        $this->pushDomainEvent(new ReviewAcceptedEvent());
    }

    public function reject(): void
    {
        $this->status = new ReviewStatusEnum(ReviewStatusEnum::REJECTED);

        $this->pushDomainEvent(new ReviewRejectedEvent());
    }

    public function updateContent(string $newContent): void
    {
        $this->content = new ContentValue($newContent);
        $this->status = new ReviewStatusEnum(ReviewStatusEnum::PENDING_MODERATION);

        $this->pushDomainEvent(new ReviewContentUpdatedEvent($this));
    }

    public function remove(): void
    {
        $this->pushDomainEvent(new ReviewRemovedEvent());
    }

    public function getContent(): ContentValue
    {
        return $this->content;
    }

    public function getStatus(): ReviewStatusEnum
    {
        return $this->status;
    }

    public function getUserId(): IntegerIdValue
    {
        return $this->userId;
    }

    public function getApplicationId(): IntegerIdValue
    {
        return $this->applicationId;
    }

    public function getCreatedAt(): DatetimeValue
    {
        return $this->createdAt;
    }
}
