<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Vegetable\Domain;

use Core\Vegetable\Domain\VegetableName;

final class VegetableNameMother
{
    public static function create(?string $name = null): VegetableName
    {
        return new VegetableName($name ?? uniqid('Vegetable', true));
    }
}