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
                    'min:' . DomainConfig::MIN_CONTENT_LENGTH,
                    'max:' . DomainConfig::MAX_CONTENT_LENGTH,
                ],
                'version' => [
                    'required',
                    'integer',
                    'min:1',
                ],
            ],
            [
                'content.required' =>
                    'The content is required',
                'content.string' =>
                    'The content must be textual',
                'content.min' =>
                    'The content length must be greater than ' . DomainConfig::MIN_CONTENT_LENGTH . ' symbols',
                'content.max' =>
                    'The content length must be less than ' . DomainConfig::MAX_CONTENT_LENGTH . ' symbols',
                'version.required' =>
                    'The version is required',
                'version.integer' =>
                    'The version must be an integer',
                'version.min' =>
                    'The version must be greater than 0',
            ]
        );
    }
}
