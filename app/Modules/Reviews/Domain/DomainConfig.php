<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain;

class DomainConfig
{
    /**
     * Limits on length of review textual content
     */
    public const MIN_CONTENT_LENGTH = 10;
    public const MAX_CONTENT_LENGTH = 1000;
}
