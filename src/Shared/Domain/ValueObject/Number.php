<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

class Number
{
    public function __construct(
        private readonly int|float $value
    ) {
    }

    public function value(): int|float
    {
        return $this->value;
    }
}