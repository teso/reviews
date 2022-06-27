<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Entity;

use App\Modules\Reviews\Domain\Event\CreateReviewEvent;
use App\Modules\Reviews\Domain\Event\ReviewAcceptedEvent;
use App\Modules\Reviews\Domain\Event\ReviewContentUpdatedEvent;
use App\Modules\Reviews\Domain\Event\ReviewRejectedEvent;
use App\Modules\Reviews\Domain\Event\ReviewRemovedEvent;
use App\Modules\Reviews\Domain\ValueObject\ContentValue;
use App\Modules\Reviews\Domain\ValueObject\DatetimeValue;
use App\Modules\Reviews\Domain\ValueObject\IntegerIdValue;
use App\Modules\Reviews\Domain\ValueObject\StatusEnum;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="reviews",
 *     options={"comment": "Stores reviews data"}
 * )
 */
class Review implements AggregateRootInterface, Arrayable
{
    use AggregateRootTrait;
    use EntityTrait;

    /**
     * @ORM\Column(
     *     type = "reviewContent",
     *     name = "content",
     *     options = {"comment": "Text content"}
     * )
     */
    private $content;

    /**
     * @ORM\Column(
     *     type = "reviewStatusEnum",
     *     name = "status",
     *     options = {"comment": "Status name"}
     * )
     */
    private $status;

    /**
     * @ORM\Column(
     *     type = "integerIdValue",
     *     name = "userId",
     *     options = {"comment": "Author id"}
     * )
     */
    private $userId;

    /**
     * @ORM\Column(
     *     type = "integerIdValue",
     *     name = "applicationId",
     *     options = {"comment": "Application id where the review was made"}
     * )
     */
    private $applicationId;

    /**
     * @ORM\Column(
     *     type = "datetimeValue",
     *     name = "createdAt",
     *     options = {"comment": "Creation time"}
     * )
     */
    private $createdAt;

    public static function createReview(
        string $content,
        int $userId,
        int $applicationId
    ) {
        $review = new self(
            $content,
            StatusEnum::PENDING_MODERATION,
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
        $this->status = new StatusEnum($status);
        $this->userId = new IntegerIdValue($userId);
        $this->applicationId = new IntegerIdValue($applicationId);
        $this->createdAt = new DatetimeValue($createdAt);
    }

    public function accept(): void
    {
        $this->status = new StatusEnum(StatusEnum::ACCEPTED);

        $this->pushDomainEvent(new ReviewAcceptedEvent());
    }

    public function reject(): void
    {
        $this->status = new StatusEnum(StatusEnum::REJECTED);

        $this->pushDomainEvent(new ReviewRejectedEvent());
    }

    public function updateContent(string $newContent): void
    {
        $this->content = new ContentValue($newContent);
        $this->status = new StatusEnum(StatusEnum::PENDING_MODERATION);

        $this->pushDomainEvent(new ReviewContentUpdatedEvent($this));
    }

    public function remove(): void
    {
        $this->pushDomainEvent(new ReviewRemovedEvent());
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->getValue(),
            'content' => $this->content->getValue(),
            'status' => $this->status->getValue(),
            'userId' => $this->userId->getValue(),
            'applicationId' => $this->applicationId->getValue(),
            'createdAt' => $this->createdAt->getValue(),
            //'version' => $this->version,
        ];
    }

    public function getContent(): ContentValue
    {
        return $this->content;
    }

    public function getStatus(): StatusEnum
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
