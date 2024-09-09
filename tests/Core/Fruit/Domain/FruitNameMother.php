<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Fruit\Domain;

use Core\Fruit\Domain\FruitName;

final class FruitNameMother
{
    public static function create(?string $name = null): FruitName
    {
        return new FruitName($name ?? uniqid('fruit', true));
    }
}