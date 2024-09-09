<?php

declare(strict_types=1);

namespace Core\Fruit\Domain;

use Shared\Domain\Criteria\Criteria;

interface FruitRepository
{
    public function add(Fruit $item): void;

    public function find(FruitId $id): ?Fruit;

    public function list(Criteria $criteria): Fruits;

    public function delete(FruitId $id): void;
}