<?php

declare(strict_types=1);

namespace Core\Vegetable\Domain;

use Shared\Domain\Criteria\Criteria;

interface VegetableRepository
{
    public function add(Vegetable $item): void;

    public function find(VegetableId $id): ?Vegetable;

    public function list(Criteria $criteria): Vegetables;

    public function delete(VegetableId $id): void;
}