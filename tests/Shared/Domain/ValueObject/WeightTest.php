<?php

declare(strict_types=1);

namespace FAV\Tests\Shared\Domain\ValueObject;

use Core\Shared\Domain\ValueObjects\Weight;
use PHPUnit\Framework\TestCase;
use Random\Randomizer;
use Shared\Domain\Exception\InvalidUnitException;
use Shared\Domain\Exception\NumberMustBePositiveException;

class WeightTest extends TestCase
{
    private function randomizer(): Randomizer
    {
        return (new Randomizer());
    }

    private function randomInteger(): int
    {
        return $this->randomizer()->getInt(0, 1000);
    }

    private function randomFloat(): float
    {
        return $this->randomizer()->getFloat(0, 1000);
    }

    /** @test */
    public function it_should_keep_integer_weight_in_grams(): void
    {
        $value  = $this->randomInteger();
        $weight = WeightMother::create($value, Weight::UNIT_GRAM);

        $this->assertSame((float)$value, $weight->value());
        $this->assertSame((float)$value, $weight->toGrams());
        $this->assertSame((float)$value/1000, $weight->toKilograms());
    }

    /** @test */
    public function it_should_convert_integer_weight_in_kilograms_to_grams(): void
    {
        $value  = $this->randomInteger();
        $weight = WeightMother::create($value, Weight::UNIT_KILO_GRAMS);

        $this->assertSame((float)$value * 1000, $weight->value());
        $this->assertSame((float)$value, $weight->toKilograms());
    }

    /** @test */
    public function it_should_throw_an_exception_on_invalid_unit(): void
    {
        $this->expectException(InvalidUnitException::class);

        WeightMother::create($this->randomInteger(), 'super_imaginary_unit');
    }

    /** @test */
    public function it_should_throw_an_exception_on_negative_quantity_when_is_integer(): void
    {
        $this->expectException(NumberMustBePositiveException::class);

       WeightMother::create($this->randomInteger() * -1, Weight::UNIT_GRAM);
    }

    /** @test */
    public function it_should_throw_an_exception_on_negative_weight_when_is_float(): void
    {
        $this->expectException(NumberMustBePositiveException::class);

        WeightMother::create($this->randomFloat() * -1, Weight::UNIT_GRAM);
    }
}