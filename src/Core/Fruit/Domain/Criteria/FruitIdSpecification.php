<?php

declare(strict_types=1);

namespace Core\Fruit\Domain\Criteria;

use Core\Fruit\Domain\Fruit;
use Core\Fruit\Domain\FruitId;
use Core\Shared\Domain\Item;
use Shared\Domain\Criteria\Specification;

final readonly class FruitIdSpecification implements Specification
{
    public function __construct(
        private FruitId $id
    ) {
    }

    public function isSatisfiedBy(Fruit|Item $item): bool
    {
        return $this->id->sameValueAs($item->id());
    }
}