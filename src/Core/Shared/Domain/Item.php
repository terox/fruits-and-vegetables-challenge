<?php

namespace Core\Shared\Domain;

use Shared\Domain\ValueObject\Identity;

interface Item
{
    public function id(): Identity;

    public function toPrimitives(): array;
}