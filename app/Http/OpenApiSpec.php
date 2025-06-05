<?php

declare(strict_types=1);

namespace App\Http;

use OpenApi\Attributes as OA;

#[OA\OpenApi(
    info: new OA\Info(
        title: "Reviews API",
        version: "1.0.0",
        description: "This API allows to manage the reviews",
    )
)]
class OpenApiSpec
{
}
