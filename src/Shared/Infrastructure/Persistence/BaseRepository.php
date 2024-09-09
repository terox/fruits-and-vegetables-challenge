<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence;

use Core\Shared\Domain\Collection;
use Core\Shared\Domain\Item;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\ValueObject\Identity;

abstract class BaseRepository implements Repository
{
    /**
     * Save the item into the persistence layer.
     *
     * @param Item $item
     *
     * @return void
     */
    abstract protected function save(Item $item): void;

    /**
     * Fetch a results from persistence layer.
     *
     * @param Criteria $criteria
     *
     * @return Collection
     */
    abstract protected function fetch(Criteria $criteria): Collection;

    /**
     * Remove an item from the persistence layer.
     *
     * @param Identity $identity
     *
     * @return void
     */
   abstract protected function remove(Identity $identity): void;
}