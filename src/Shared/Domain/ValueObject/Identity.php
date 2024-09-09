<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

class Identity
{
    public function __construct(
        private readonly int $value
    ) {
    }

    public function sameValueAs(Identity $id): bool
    {
        return $this->value === $id->value();
    }

    public function value(): int
    {
        return $this->value;
    }
}