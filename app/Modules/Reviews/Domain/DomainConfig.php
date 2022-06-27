<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Domain;

class DomainConfig
{
    /**
     * Limits on length of review textual content
     */
    public const MINIMUM_CONTENT_LENGTH = 10;
    public const MAXIMUM_CONTENT_LENGTH = 1000;
}
