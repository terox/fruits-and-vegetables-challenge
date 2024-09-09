<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Fruit\Domain;

use Core\Fruit\Domain\FruitId;

final class FruitIdMother
{
    public static function create(?int $id = null): FruitId
    {
        return new FruitId($id ?? random_int(0, 100));
    }
}