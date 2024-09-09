<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;

use Core\Shared\Domain\Item;

interface Specification
{
    public function isSatisfiedBy(Item $item): bool;
}