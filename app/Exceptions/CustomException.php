<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected int $statusCode;

    protected array $errors;

    public function __construct(string $message = 'Something went wrong.',int $statusCode = 400,array $errors = [], int $code = 0, ?Exception $previous = null) {
        parent::__construct($message, $code, $previous);

        $this->statusCode = $statusCode;
        $this->errors = $errors;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
