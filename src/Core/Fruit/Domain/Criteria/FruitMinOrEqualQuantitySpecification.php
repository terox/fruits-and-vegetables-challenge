<?php

declare(strict_types=1);

namespace Core\Fruit\Domain\Criteria;

use Core\Fruit\Domain\Fruit;
use Core\Fruit\Domain\FruitQuantity;
use Core\Shared\Domain\Item;
use Shared\Domain\Criteria\Specification;

final readonly class FruitMinOrEqualQuantitySpecification implements Specification
{
    public function __construct(
        private FruitQuantity $minQuantity
    ) {
    }

    public function isSatisfiedBy(Fruit|Item $item): bool
    {
        return $item->quantity()->value() >= $this->minQuantity->value();
    }
}