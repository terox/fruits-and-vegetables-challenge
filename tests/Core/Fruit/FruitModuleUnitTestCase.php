<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Fruit;

use Core\Fruit\Domain\FruitRepository;
use Core\Fruit\Domain\Fruits;
use FAV\Tests\Core\Fruit\Domain\FruitIdMother;
use FAV\Tests\Core\Fruit\Domain\FruitMother;
use FAV\Tests\Core\Fruit\Domain\FruitNameMother;
use FAV\Tests\Core\Fruit\Domain\FruitQuantityMother;
use FAV\Tests\Shared\Infrastructure\Testing\PHPUnit\TestCase;
use Mockery\MockInterface;

abstract class FruitModuleUnitTestCase extends TestCase
{
    // Here we need to define the two interfaces to avoid type errors.
    private FruitRepository|MockInterface|null $repository = null;

    protected function repositoryShouldReturn(Fruits $results): void
    {
        $this->repository()
            ->expects('list')
            ->once()
            ->andReturn($results);
    }

    protected function repositoryReturnExampleCollection(): void
    {
        $this->repositoryShouldReturn(new Fruits([
            FruitMother::create(
                FruitIdMother::create(1),
                FruitNameMother::create('Hello World Fruit 1'),
                FruitQuantityMother::create(1000)
            ),
            FruitMother::create(
                FruitIdMother::create(2),
                FruitNameMother::create('Hello World Fruit 2'),
                FruitQuantityMother::create(1500)
            ),
            FruitMother::create(
                FruitIdMother::create(500),
                FruitNameMother::create('Hello World Fruit 500'),
                FruitQuantityMother::create(5050)
            ),
        ]));
    }

    protected function repository(): FruitRepository|MockInterface
    {
        return $this->repository ??= $this->mock(FruitRepository::class);
    }
}