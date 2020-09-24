<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

class DDDBaseException
{
    private array $data;
    private int $statusCode = 422;

    public function __construct(string $errorName, string $messageContent)
    {
        $this->data = [
            "errors" => [
                $errorName => $messageContent,
            ],
        ];
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
    public function getJson()
    {
        return new JsonResponse($this->data, $this->statusCode);
    }
}
