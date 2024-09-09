<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Vegetable\Domain;

use Core\Vegetable\Domain\VegetableQuantity;

final class VegetableQuantityMother
{
    public static function create(?int $quantity = null, ?string $unit = null): VegetableQuantity
    {
        return new VegetableQuantity($quantity ?? 500, $unit ?? 'g');
    }
}