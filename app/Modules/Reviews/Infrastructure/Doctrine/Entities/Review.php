<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Infrastructure\Doctrine\Entities;

use App\Modules\Reviews\Domain\DomainConfig;
use App\Modules\Reviews\Domain\Entities\Review as DomainReview;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

#[ORM\Entity]
#[ORM\Table(
    name: "reviews",
    options: ["comment" => "Stores reviews data"]
)]
class Review
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(
            type: "integer",
        )]
        private ?int $id,

        #[ORM\Column(
            name: "content",
            type: "string",
            nullable: false,
            length: DomainConfig::MAX_CONTENT_LENGTH,
            options: ["comment" => "Text content"]
        )]
        private string $content,

        #[ORM\Column(
            name: "status",
            type: "string",
            nullable: false,
            columnDefinition: "ENUM('pending_moderation', 'accepted', 'rejected')",
            options: ["comment" => "Status name"]
        )]
        private string $status,

        #[ORM\Column(
            name: "userId",
            type: "integer",
            nullable: false,
            options: [
                "unsigned" => true,
                "comment" => "Author id",
            ]
        )]
        private int $userId,

        #[ORM\Column(
            name: "applicationId",
            type: "integer",
            nullable: false,
            options: [
                "unsigned" => true,
                "comment" => "Application id where the review was made",
            ]
        )]
        private int $applicationId,

        #[ORM\Column(
            name: "createdAt",
            type: "datetime_immutable",
            nullable: false,
            options: ["comment" => "Creation time"]
        )]
        private DateTimeImmutable $createdAt,

        #[ORM\Version]
        #[ORM\Column(
            type: "integer",
            options: ["unsigned" => true, "comment" => "Version of aggregate"]
        )]
        private ?int $version,
    ) {
    }

    public function toDomain(): DomainReview
    {
        $review = new DomainReview(
            $this->content,
            $this->status,
            $this->userId,
            $this->applicationId,
            $this->createdAt->format("Y-m-d H:i:s"),
        );

        $review->setId($this->id);
        $review->setVersion($this->version);

        return $review;
    }

    public static function fromDomain(DomainReview $review): self
    {
        return new self(
            $review->getId()?->getValue(),
            $review->getContent()->getValue(),
            $review->getStatus()->getValue(),
            $review->getUserId()->getValue(),
            $review->getApplicationId()->getValue(),
            new DateTimeImmutable($review->getCreatedAt()->getValue()),
            $review->getVersion(),
        );
    }

    public function updateFromDomain(DomainReview $review): void
    {
        $this->content = $review->getContent()->getValue();
        $this->status = $review->getStatus()->getValue();
        $this->version = $review->getVersion();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }
}
