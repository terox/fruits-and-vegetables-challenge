<?php

declare(strict_types=1);

namespace Core\Shared\Domain;

use Shared\Domain\Criteria\Criteria;

abstract class BaseCollection implements Collection
{
    public function __construct(
        private readonly array $items = []
    ) {
    }

    public function filter(Criteria $criteria): Collection
    {
        $results = [];
        foreach($this->items as $item) {
            if(!$criteria->isSatisfiedBy($item)) {
                continue;
            }

            $results[] = $item;
        }

        return new static($results);
    }

    public function getOneOrNull(int $index): ?Item
    {
        return $this->items[$index] ?? null;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}