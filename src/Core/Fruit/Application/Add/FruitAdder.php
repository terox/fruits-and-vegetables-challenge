<?php

declare(strict_types=1);

namespace Core\Fruit\Application\Add;

use Core\Fruit\Domain\Exception\FruitAlreadyExistsException;
use Core\Fruit\Domain\Fruit;
use Core\Fruit\Domain\FruitId;
use Core\Fruit\Domain\FruitName;
use Core\Fruit\Domain\FruitQuantity;
use Core\Fruit\Domain\FruitRepository;

final class FruitAdder
{
    public function __construct(
        private readonly FruitRepository $repository
    ) {
    }

    public function __invoke(
        FruitId $id,
        FruitName $name,
        FruitQuantity $quantity
    ): void {
        $fruit = $this->repository->find($id);

        if(null !== $fruit) {
            throw new FruitAlreadyExistsException($id);
        }

        $fruit = Fruit::create($id, $name, $quantity);

        $this->repository->add($fruit);
    }
}