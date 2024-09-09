<?php

declare(strict_types=1);

namespace Core\Vegetable\Application\List;

use Core\Shared\Domain\ValueObjects\Weight;
use Core\Vegetable\Application\VegetableResponseConverter;
use Core\Vegetable\Application\VegetablesResponse;
use Core\Vegetable\Domain\Vegetable;
use Core\Vegetable\Domain\VegetableRepository;
use Shared\Domain\Criteria\Criteria;

final readonly class VegetableLister
{
    public function __construct(
        private VegetableRepository $repository
    ) {
    }

    public function __invoke(Criteria $criteria, string $quantityUnit = Weight::UNIT_GRAM): VegetablesResponse
    {
        $vegetables = $this->repository->list($criteria);

        return new VegetablesResponse(...array_map(
            static fn(Vegetable $vegetable) => (new VegetableResponseConverter($quantityUnit))($vegetable),
            $vegetables->toArray()
        ));
    }
}