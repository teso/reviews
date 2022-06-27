<?php

declare(strict_types=1);

namespace App\Http\Validator;

use App\Modules\Reviews\Domain\DomainConfig;
use Illuminate\Support\Facades\Validator;

class UpdateReviewValidatorFactory
{
    public static function create(array $data)
    {
        return Validator::make(
            $data,
            [
                'content' => [
                    'required',
                    'string',
                    'min:' . DomainConfig::MINIMUM_CONTENT_LENGTH,
                    'max:' . DomainConfig::MAXIMUM_CONTENT_LENGTH,
                ],
            ],
            [
                'content.required' =>
                    'The content is required.',
                'content.string' =>
                    'The content must be textual',
                'content.min' =>
                    'The content length must be greater than ' . DomainConfig::MINIMUM_CONTENT_LENGTH . ' symbols.',
                'content.max' =>
                    'The content length must be less than ' . DomainConfig::MAXIMUM_CONTENT_LENGTH . ' symbols.',
            ]
        );
    }
}
