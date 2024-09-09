<?php

declare(strict_types=1);

namespace Core\Vegetable\Domain\Exception;

use Core\Vegetable\Domain\VegetableId;
use Shared\Domain\Exception\DomainException;

class VegetableAlreadyExistsException extends DomainException
{
    public function __construct(
        private readonly VegetableId $id
    ) {
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return sprintf('The vegetable with ID <%s> is already created!', $this->id->value());
    }

    protected function errorCode(): int
    {
        return 200;
    }
}