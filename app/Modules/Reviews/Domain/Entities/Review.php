<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Entities;

use App\Modules\Reviews\Domain\Events\CreateReviewEvent;
use App\Modules\Reviews\Domain\Events\ReviewAcceptedEvent;
use App\Modules\Reviews\Domain\Events\ReviewContentUpdatedEvent;
use App\Modules\Reviews\Domain\Events\ReviewRejectedEvent;
use App\Modules\Reviews\Domain\Events\ReviewRemovedEvent;
use App\Modules\Reviews\Domain\ValueObjects\ContentValue;
use App\Modules\Reviews\Domain\ValueObjects\DatetimeValue;
use App\Modules\Reviews\Domain\ValueObjects\IntegerIdValue;
use App\Modules\Reviews\Domain\ValueObjects\StatusValue;

class Review implements AggregateRootInterface
{
    use AggregateRootTrait;
    use EntityTrait;

    private $content;
    private $status;
    private $userId;
    private $applicationId;
    private $createdAt;

    public static function create(
        string $content,
        int $userId,
        int $applicationId
    ) {
        $review = new self(
            $content,
            StatusValue::PENDING_MODERATION->getValue(),
            $userId,
            $applicationId,
            date('Y-m-d H:i:s')
        );

        $review->pushDomainEvent(new CreateReviewEvent($review));

        return $review;
    }

    public function __construct(
        string $content,
        string $status,
        int $userId,
        int $applicationId,
        string $createdAt
    ) {
        $this->content = new ContentValue($content);
        $this->status = StatusValue::from($status);
        $this->userId = new IntegerIdValue($userId);
        $this->applicationId = new IntegerIdValue($applicationId);
        $this->createdAt = new DatetimeValue($createdAt);
    }

    public function accept(): void
    {
        $this->status = StatusValue::ACCEPTED;

        $this->pushDomainEvent(new ReviewAcceptedEvent());
    }

    public function reject(): void
    {
        $this->status = StatusValue::REJECTED;

        $this->pushDomainEvent(new ReviewRejectedEvent());
    }

    public function updateContent(string $newContent, int $version): void
    {
        $this->content = new ContentValue($newContent);
        $this->status = StatusValue::PENDING_MODERATION;
        $this->version = $version;

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

    public function getStatus(): StatusValue
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
