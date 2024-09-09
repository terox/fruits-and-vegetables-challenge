<?php

declare(strict_types=1);

namespace Core\Fruit\Domain\Exception;

use Core\Fruit\Domain\FruitId;
use Shared\Domain\Exception\DomainException;

class FruitNotExistsException extends DomainException
{
    public function __construct(
        private readonly FruitId $id
    ) {
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return sprintf('The fruit with ID <%s> does not exist', $this->id->value());
    }

    protected function errorCode(): int
    {
        return 101;
    }
}