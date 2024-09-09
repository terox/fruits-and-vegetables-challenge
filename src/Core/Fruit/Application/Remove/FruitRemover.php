<?php

declare(strict_types=1);

namespace Core\Fruit\Application\Remove;

use Core\Fruit\Domain\Exception\FruitNotExistsException;
use Core\Fruit\Domain\FruitId;
use Core\Fruit\Domain\FruitRepository;

final readonly class FruitRemover
{
    public function __construct(
        private FruitRepository $repository
    ) {
    }

    public function __invoke(FruitId $id): void
    {
        $fruit = $this->repository->find($id);

        if(null === $fruit) {
            throw new FruitNotExistsException($id);
        }

        $this->repository->delete($id);
    }
}