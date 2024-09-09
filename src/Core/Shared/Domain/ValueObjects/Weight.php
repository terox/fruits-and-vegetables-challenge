<?php

declare(strict_types=1);

namespace Core\Shared\Domain\ValueObjects;

use Shared\Domain\Exception\InvalidUnitException;
use Shared\Domain\Exception\NumberMustBePositiveException;
use Shared\Domain\ValueObject\Number;

class Weight extends Number
{
    // Units
    public const string UNIT_GRAM       = 'g';
    public const string UNIT_KILO_GRAMS = 'kg';

    private const array UNITS = [
        self::UNIT_GRAM,
        self::UNIT_KILO_GRAMS
    ];

    // Scale
    private const int SCALE_GRAMS      = 1;
    private const int SCALE_KILO_GRAMS = 1000;

    /**
     * Weight in grams.
     *
     * @var float
     */
    private readonly float $weight;

    public function __construct(int|float $value, string $unit)
    {
        $unit = strtolower($unit);

        $this->assertThatIsPositive($value);
        $this->assertThatIsValidUnit($unit);

        $this->weight = $this->convertToGrams((float)$value, $unit);

        parent::__construct($this->weight);
    }

    private function assertThatIsPositive($value): void
    {
        if($value > 0) {
            return;
        }

        throw new NumberMustBePositiveException($value);
    }

    private function assertThatIsValidUnit(string $unit): void
    {
        if(in_array(strtolower($unit), self::UNITS, true)) {
            return;
        }

        throw new InvalidUnitException($unit, self::UNITS);
    }

    private function convertToGrams(float $value, string $unit): float
    {
        return match (strtolower($unit)) {
            self::UNIT_KILO_GRAMS => $value * self::SCALE_KILO_GRAMS,
            self::UNIT_GRAM       => $value * self::SCALE_GRAMS
        };
    }

    public function convertTo(string $targetUnit): float
    {
        $this->assertThatIsValidUnit($targetUnit);

        return match (strtolower($targetUnit)) {
            self::UNIT_KILO_GRAMS => $this->weight / self::SCALE_KILO_GRAMS,
            self::UNIT_GRAM       => $this->weight / self::SCALE_GRAMS,
        };
    }

    public function toKilograms(): float
    {
        return $this->convertTo(self::UNIT_KILO_GRAMS);
    }

    public function toGrams(): float
    {
        return $this->value();
    }
}