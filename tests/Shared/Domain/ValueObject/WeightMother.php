<?php

declare(strict_types=1);

namespace FAV\Tests\Shared\Domain\ValueObject;

use Core\Shared\Domain\ValueObjects\Weight;

final class WeightMother
{
    public static function create(int|float $value, string $unit): Weight
    {
        return new Weight($value, $unit);
    }
}