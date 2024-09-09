<?php

namespace Shared\Domain\Criteria;

use Core\Shared\Domain\Item;

/**
 * Criteria.
 *
 * Must follow all specifications to be a match.
 */
final readonly class Criteria implements Specification
{
    private array $specifications;

    public function __construct(Specification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public static function empty(): self
    {
        return new self();
    }

    public static function create(Specification ...$specifications): self
    {
        return new self(...$specifications);
    }

    public function isSatisfiedBy(Item $item): bool
    {
        foreach($this->specifications as $specification) {
            if(!$specification->isSatisfiedBy($item)) {
                return false;
            }
        }

        return true;
    }
}