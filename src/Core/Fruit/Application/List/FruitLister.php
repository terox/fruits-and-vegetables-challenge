<?php

declare(strict_types=1);

namespace Core\Fruit\Application\List;

use Core\Fruit\Application\FruitResponseConverter;
use Core\Fruit\Application\FruitsResponse;
use Core\Fruit\Domain\Fruit;
use Core\Fruit\Domain\FruitRepository;
use Core\Shared\Domain\ValueObjects\Weight;
use Shared\Domain\Criteria\Criteria;

final readonly class FruitLister
{
    public function __construct(
        private FruitRepository $repository
    ) {
    }

    public function __invoke(Criteria $criteria, string $quantityUnit = Weight::UNIT_GRAM): FruitsResponse
    {
        $fruits = $this->repository->list($criteria);

        return new FruitsResponse(...array_map(
            static fn(Fruit $fruit) => (new FruitResponseConverter($quantityUnit))($fruit),
            $fruits->toArray()
        ));
    }
}