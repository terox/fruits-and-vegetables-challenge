<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Vegetable\Domain;

use Core\Vegetable\Domain\Vegetable;
use Core\Vegetable\Domain\VegetableId;
use Core\Vegetable\Domain\VegetableName;
use Core\Vegetable\Domain\VegetableQuantity;

final class VegetableMother
{
    public static function create(
        ?VegetableId $id = null,
        ?VegetableName $name = null,
        ?VegetableQuantity $quantity = null
    ): Vegetable
    {
        return Vegetable::create(
            $id ?? VegetableIdMother::create(),
            $name ?? VegetableNameMother::create(),
            $quantity ?? VegetableQuantityMother::create()
        );
    }

    public static function createWithQuantity(VegetableQuantity $quantity, ?VegetableId $id = null): Vegetable
    {
        return Vegetable::create(
            $id ?? VegetableIdMother::create(),
            VegetableNameMother::create(),
            $quantity
        );
    }
}