<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Vegetable\Application\Add;

use Core\Vegetable\Application\Add\VegetableAdder;
use Core\Vegetable\Domain\Exception\VegetableAlreadyExistsException;
use Core\Vegetable\Domain\Vegetable;
use FAV\Tests\Core\Vegetable\Domain\VegetableIdMother;
use FAV\Tests\Core\Vegetable\Domain\VegetableMother;
use FAV\Tests\Core\Vegetable\Domain\VegetableNameMother;
use FAV\Tests\Core\Vegetable\Domain\VegetableQuantityMother;
use FAV\Tests\Core\Vegetable\VegetableModuleUnitTestCase;

final class VegetableAdderUnitTest extends VegetableModuleUnitTestCase
{
    private VegetableAdder $adder;

    protected function setUp(): void
    {
        $this->adder = new VegetableAdder($this->repository());
    }

    /** @test */
    public function it_should_add_a_new_Vegetable(): void
    {
        $vegetable = VegetableMother::create();

        $this->repository()
            ->expects('find')
            ->once()
            ->with($vegetable->id())
            ->andReturnNull();

        $this->repository()
            ->expects('add')
            ->once()
            ->withArgs(static function(Vegetable $arg) use ($vegetable) {
                return $vegetable->id()->value() === $arg->id()->value() &&
                    $vegetable->name()->value() === $arg->name()->value() &&
                    $vegetable->quantity()->value() === $arg->quantity()->value();
            });

        $this->adder->__invoke(
            $vegetable->id(),
            $vegetable->name(),
            $vegetable->quantity()
        );
    }

    /** @test */
    public function it_should_throws_an_exception_when_Vegetable_exists(): void
    {
        $this->expectException(VegetableAlreadyExistsException::class);

        $this->repository()
            ->expects('find')
            ->once()
            ->andReturn(VegetableMother::create());

        $this->adder->__invoke(
            VegetableIdMother::create(),
            VegetableNameMother::create(),
            VegetableQuantityMother::create()
        );
    }
}