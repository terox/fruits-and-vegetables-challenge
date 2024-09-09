<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Fruit\Application\Add;

use Core\Fruit\Application\Add\FruitAdder;
use Core\Fruit\Domain\Exception\FruitAlreadyExistsException;
use Core\Fruit\Domain\Fruit;
use FAV\Tests\Core\Fruit\Domain\FruitIdMother;
use FAV\Tests\Core\Fruit\Domain\FruitMother;
use FAV\Tests\Core\Fruit\Domain\FruitNameMother;
use FAV\Tests\Core\Fruit\Domain\FruitQuantityMother;
use FAV\Tests\Core\Fruit\FruitModuleUnitTestCase;

final class FruitAdderUnitTest extends FruitModuleUnitTestCase
{
    private FruitAdder $adder;

    protected function setUp(): void
    {
        $this->adder = new FruitAdder($this->repository());
    }

    /** @test */
    public function it_should_add_a_new_fruit(): void
    {
        $fruit = FruitMother::create();

        $this->repository()
            ->expects('find')
            ->once()
            ->with($fruit->id())
            ->andReturnNull();

        $this->repository()
            ->expects('add')
            ->once()
            ->withArgs(static function(Fruit $arg) use ($fruit) {
                return $fruit->id()->value() === $arg->id()->value() &&
                    $fruit->name()->value() === $arg->name()->value() &&
                    $fruit->quantity()->value() === $arg->quantity()->value();
            });

        $this->adder->__invoke(
            $fruit->id(),
            $fruit->name(),
            $fruit->quantity()
        );
    }

    /** @test */
    public function it_should_throws_an_exception_when_fruit_exists(): void
    {
        $this->expectException(FruitAlreadyExistsException::class);

        $this->repository()
            ->expects('find')
            ->once()
            ->andReturn(FruitMother::create());

        $this->adder->__invoke(
            FruitIdMother::create(),
            FruitNameMother::create(),
            FruitQuantityMother::create()
        );
    }
}