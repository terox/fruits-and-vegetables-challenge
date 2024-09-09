<?php

declare(strict_types=1);

namespace Core\Vegetable\Domain\Criteria;

use Core\Vegetable\Domain\Vegetable;
use Core\Vegetable\Domain\VegetableQuantity;
use Core\Shared\Domain\Item;
use Shared\Domain\Criteria\Specification;

final readonly class VegetableMinOrEqualQuantitySpecification implements Specification
{
    public function __construct(
        private VegetableQuantity $minQuantity
    ) {
    }

    public function isSatisfiedBy(Vegetable|Item $item): bool
    {
        return $item->quantity()->value() >= $this->minQuantity->value();
    }
}