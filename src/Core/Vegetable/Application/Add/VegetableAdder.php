<?php

declare(strict_types=1);

namespace Core\Vegetable\Application\Add;

use Core\Vegetable\Domain\Exception\VegetableAlreadyExistsException;
use Core\Vegetable\Domain\Vegetable;
use Core\Vegetable\Domain\VegetableId;
use Core\Vegetable\Domain\VegetableName;
use Core\Vegetable\Domain\VegetableQuantity;
use Core\Vegetable\Domain\VegetableRepository;

final class VegetableAdder
{
    public function __construct(
        private readonly VegetableRepository $repository
    ) {
    }

    public function __invoke(
        VegetableId       $id,
        VegetableName     $name,
        VegetableQuantity $quantity
    ): void {
        $vegetable = $this->repository->find($id);

        if(null !== $vegetable) {
            throw new VegetableAlreadyExistsException($id);
        }

        $vegetable = Vegetable::create($id, $name, $quantity);

        $this->repository->add($vegetable);
    }
}