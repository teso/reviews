<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain\Exception\Repository;

use App\Modules\Reviews\Domain\Exception\AbstractRuntimeException;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class ReviewEntityNotFoundException extends AbstractRuntimeException
{
    public function __construct(int $reviewId)
    {
        parent::__construct(
            sprintf('Review id: %s', $reviewId),
            404
        );
    }

}
