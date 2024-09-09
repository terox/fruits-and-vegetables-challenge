<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Fruit\Domain;

use Core\Fruit\Domain\FruitQuantity;

final class FruitQuantityMother
{
    public static function create(?int $quantity = null, ?string $unit = null): FruitQuantity
    {
        return new FruitQuantity($quantity ?? 500, $unit ?? 'g');
    }
}