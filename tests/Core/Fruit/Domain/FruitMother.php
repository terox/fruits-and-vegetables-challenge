<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Fruit\Domain;

use Core\Fruit\Domain\Fruit;
use Core\Fruit\Domain\FruitId;
use Core\Fruit\Domain\FruitName;
use Core\Fruit\Domain\FruitQuantity;

final class FruitMother
{
    public static function create(
        ?FruitId $id = null,
        ?FruitName $name = null,
        ?FruitQuantity $quantity = null
    ): Fruit
    {
        return Fruit::create(
            $id ?? FruitIdMother::create(),
            $name ?? FruitNameMother::create(),
            $quantity ?? FruitQuantityMother::create()
        );
    }

    public static function createWithQuantity(FruitQuantity $quantity, ?FruitId $id = null): Fruit
    {
        return Fruit::create(
            $id ?? FruitIdMother::create(),
            FruitNameMother::create(),
            $quantity
        );
    }
}