<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Event;

use App\Modules\Reviews\Domain\Entity\Review;
use App\Modules\Reviews\Domain\ValueObject\ContentValue;
use App\Modules\Reviews\Domain\ValueObject\DatetimeValue;
use App\Modules\Reviews\Domain\ValueObject\IntegerIdValue;
use App\Modules\Reviews\Domain\ValueObject\StatusEnum;

trait ReviewDataCarrierTrait
{
    private $content;
    private $status;
    private $userId;
    private $applicationId;
    private $createdAt;

    public function __construct(Review $review)
    {
        $this->content = $review->getContent();
        $this->status = $review->getStatus();
        $this->userId = $review->getUserId();
        $this->applicationId = $review->getApplicationId();
        $this->createdAt = $review->getCreatedAt();
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
