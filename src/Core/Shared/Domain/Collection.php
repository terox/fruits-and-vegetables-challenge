<?php

declare(strict_types=1);

namespace Core\Shared\Domain;

use Shared\Domain\Criteria\Criteria;

interface Collection
{
    /**
     * Return a new Collection instance with filtered items.
     *
     * @param Criteria $criteria
     *
     * @return Collection
     */
    public function filter(Criteria $criteria): Collection;

    /**
     * Return one element or null.
     *
     * @param int $index
     *
     * @return Item|null
     */
    public function getOneOrNull(int $index): ?Item;

    /**
     * Return all items in array
     *
     * @return Item[]
     */
    public function toArray(): array;
}