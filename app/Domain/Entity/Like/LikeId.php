<?php

namespace App\Domain\Entity\Like;

use App\Exceptions\DomainException;

class LikeId
{
    private string $value;
    public function __construct(string $uuid)
    {
        if (is_null($uuid)) {
            throw new DomainException("like_id", "like_id is required");
        }
        $this->value = $uuid;
    }

    public function value(): string
    {
        return $this->value;
    }
}
