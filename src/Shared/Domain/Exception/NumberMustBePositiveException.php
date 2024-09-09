<?php

declare(strict_types=1);

namespace Shared\Domain\Exception;

final class NumberMustBePositiveException extends DomainException
{
    public function __construct(
        private readonly int|float $number
    )
    {
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return sprintf('Expected a positive number. You passed: <%s>', $this->number);
    }

    protected function errorCode(): int
    {
        return 302;
    }
}