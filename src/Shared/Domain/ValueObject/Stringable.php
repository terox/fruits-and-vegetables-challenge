<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

class Stringable
{
    public function __construct(
        private readonly string $value
    ) {
    }

    public function sameValueAs(string $value): bool
    {
        return $this->value === $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}