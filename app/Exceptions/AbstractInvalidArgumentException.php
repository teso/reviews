<?php

declare(strict_types=1);

namespace App\Exceptions;

use \InvalidArgumentException;

class AbstractInvalidArgumentException extends InvalidArgumentException implements ExceptionInterface
{

}
