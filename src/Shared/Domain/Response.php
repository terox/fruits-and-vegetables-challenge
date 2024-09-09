<?php

declare(strict_types=1);

namespace Shared\Domain;

interface Response
{
    public function toPrimitives(): array;
}