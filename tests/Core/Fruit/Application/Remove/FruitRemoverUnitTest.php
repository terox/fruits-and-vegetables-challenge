<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Fruit\Application\Remove;

use Core\Fruit\Application\Remove\FruitRemover;
use Core\Fruit\Domain\Exception\FruitNotExistsException;
use FAV\Tests\Core\Fruit\Domain\FruitIdMother;
use FAV\Tests\Core\Fruit\Domain\FruitMother;
use FAV\Tests\Core\Fruit\FruitModuleUnitTestCase;

final class FruitRemoverUnitTest extends FruitModuleUnitTestCase
{
    private FruitRemover $adder;

    protected function setUp(): void
    {
        $this->adder = new FruitRemover($this->repository());
    }

    /** @test */
    public function it_should_remove_a_fruit(): void
    {
        $fruit = FruitMother::create();

        $this->repository()
            ->expects('find')
            ->once()
            ->with($fruit->id())
            ->andReturn($fruit);

        $this->repository()
            ->expects('delete')
            ->once()
            ->with($fruit->id());

        $this->adder->__invoke($fruit->id());
    }

    /** @test */
    public function it_should_throws_an_exception_when_fruit_not_exists(): void
    {
        $this->expectException(FruitNotExistsException::class);

        $this->repository()
            ->expects('find')
            ->once()
            ->andReturnNull();

        $this->adder->__invoke(FruitIdMother::create());
    }
}