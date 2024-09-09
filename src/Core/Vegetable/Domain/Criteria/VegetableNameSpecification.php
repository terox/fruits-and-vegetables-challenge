<?php

declare(strict_types=1);

namespace Core\Vegetable\Domain\Criteria;

use Core\Vegetable\Domain\Vegetable;
use Core\Vegetable\Domain\VegetableName;
use Core\Shared\Domain\Item;
use Shared\Domain\Criteria\Specification;

final readonly class VegetableNameSpecification implements Specification
{
    public function __construct(
        private VegetableName $name
    ) {
    }

    public function isSatisfiedBy(Vegetable|Item $item): bool
    {
        return $this->name->sameValueAs($item->name()->value());
    }
}