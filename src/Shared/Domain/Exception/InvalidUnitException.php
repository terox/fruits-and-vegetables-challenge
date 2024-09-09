<?php

declare(strict_types=1);

namespace Shared\Domain\Exception;

final class InvalidUnitException extends DomainException
{
    public function __construct(
        private readonly string $unit,
        private readonly array $expected
    )
    {
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return sprintf('You passed <%s>. You must use next units: %s', $this->unit, implode(', ', $this->expected));
    }

    protected function errorCode(): int
    {
        return 301;
    }
}