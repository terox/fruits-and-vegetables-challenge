<?php

declare(strict_types=1);

namespace Core\Vegetable\Application\Remove;

use Core\Vegetable\Domain\Exception\VegetableNotExistsException;
use Core\Vegetable\Domain\VegetableId;
use Core\Vegetable\Domain\VegetableRepository;

final readonly class VegetableRemover
{
    public function __construct(
        private VegetableRepository $repository
    ) {
    }

    public function __invoke(VegetableId $id): void
    {
        $vegetable = $this->repository->find($id);

        if(null === $vegetable) {
            throw new VegetableNotExistsException($id);
        }

        $this->repository->delete($id);
    }
}