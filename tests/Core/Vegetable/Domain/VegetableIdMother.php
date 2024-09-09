<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Vegetable\Domain;

use Core\Vegetable\Domain\VegetableId;

final class VegetableIdMother
{
    public static function create(?int $id = null): VegetableId
    {
        return new VegetableId($id ?? random_int(0, 100));
    }
}