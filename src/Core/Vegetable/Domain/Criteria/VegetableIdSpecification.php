<?php

declare(strict_types=1);

namespace Core\Vegetable\Domain\Criteria;

use Core\Vegetable\Domain\Vegetable;
use Core\Vegetable\Domain\VegetableId;
use Core\Shared\Domain\Item;
use Shared\Domain\Criteria\Specification;

final readonly class VegetableIdSpecification implements Specification
{
    public function __construct(
        private VegetableId $id
    ) {
    }

    public function isSatisfiedBy(Vegetable|Item $item): bool
    {
        return $this->id->sameValueAs($item->id());
    }
}