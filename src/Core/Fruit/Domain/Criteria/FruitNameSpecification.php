<?php

declare(strict_types=1);

namespace Core\Fruit\Domain\Criteria;

use Core\Fruit\Domain\Fruit;
use Core\Fruit\Domain\FruitName;
use Core\Shared\Domain\Item;
use Shared\Domain\Criteria\Specification;

final readonly class FruitNameSpecification implements Specification
{
    public function __construct(
        private FruitName $name
    ) {
    }

    public function isSatisfiedBy(Fruit|Item $item): bool
    {
        return $this->name->sameValueAs($item->name()->value());
    }
}