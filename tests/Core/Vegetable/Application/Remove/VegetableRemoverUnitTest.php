<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Vegetable\Application\Remove;

use Core\Vegetable\Application\Remove\VegetableRemover;
use Core\Vegetable\Domain\Exception\VegetableNotExistsException;
use FAV\Tests\Core\Vegetable\Domain\VegetableIdMother;
use FAV\Tests\Core\Vegetable\Domain\VegetableMother;
use FAV\Tests\Core\Vegetable\VegetableModuleUnitTestCase;

final class VegetableRemoverUnitTest extends VegetableModuleUnitTestCase
{
    private VegetableRemover $adder;

    protected function setUp(): void
    {
        $this->adder = new VegetableRemover($this->repository());
    }

    /** @test */
    public function it_should_remove_a_Vegetable(): void
    {
        $vegetable = VegetableMother::create();

        $this->repository()
            ->expects('find')
            ->once()
            ->with($vegetable->id())
            ->andReturn($vegetable);

        $this->repository()
            ->expects('delete')
            ->once()
            ->with($vegetable->id());

        $this->adder->__invoke($vegetable->id());
    }

    /** @test */
    public function it_should_throws_an_exception_when_Vegetable_not_exists(): void
    {
        $this->expectException(VegetableNotExistsException::class);

        $this->repository()
            ->expects('find')
            ->once()
            ->andReturnNull();

        $this->adder->__invoke(VegetableIdMother::create());
    }
}