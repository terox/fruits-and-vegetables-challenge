<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Vegetable;

use Core\Vegetable\Domain\VegetableRepository;
use Core\Vegetable\Domain\Vegetables;
use FAV\Tests\Core\Vegetable\Domain\VegetableIdMother;
use FAV\Tests\Core\Vegetable\Domain\VegetableMother;
use FAV\Tests\Core\Vegetable\Domain\VegetableNameMother;
use FAV\Tests\Core\Vegetable\Domain\VegetableQuantityMother;
use FAV\Tests\Shared\Infrastructure\Testing\PHPUnit\TestCase;
use Mockery\MockInterface;

abstract class VegetableModuleUnitTestCase extends TestCase
{
    // Here we need to define the two interfaces to avoid type errors.
    private VegetableRepository|MockInterface|null $repository = null;

    protected function repositoryShouldReturn(Vegetables $results): void
    {
        $this->repository()
            ->expects('list')
            ->once()
            ->andReturn($results);
    }

    protected function repositoryReturnExampleCollection(): void
    {
        $this->repositoryShouldReturn(new Vegetables([
            VegetableMother::create(
                VegetableIdMother::create(1),
                VegetableNameMother::create('Hello World Vegetable 1'),
                VegetableQuantityMother::create(1000)
            ),
            VegetableMother::create(
                VegetableIdMother::create(2),
                VegetableNameMother::create('Hello World Vegetable 2'),
                VegetableQuantityMother::create(1500)
            ),
            VegetableMother::create(
                VegetableIdMother::create(500),
                VegetableNameMother::create('Hello World Vegetable 500'),
                VegetableQuantityMother::create(5050)
            ),
        ]));
    }

    protected function repository(): VegetableRepository|MockInterface
    {
        return $this->repository ??= $this->mock(VegetableRepository::class);
    }
}