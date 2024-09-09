<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Fruit\Infrastructure\Persistence\Redis;

use Core\Fruit\Domain\Criteria\FruitIdSpecification;
use Core\Fruit\Domain\Criteria\FruitMinOrEqualQuantitySpecification;
use Core\Fruit\Domain\Criteria\FruitNameSpecification;
use FAV\Tests\Core\Fruit\Domain\FruitIdMother;
use FAV\Tests\Core\Fruit\Domain\FruitMother;
use FAV\Tests\Core\Fruit\Domain\FruitQuantityMother;
use FAV\Tests\Core\Fruit\FruitModuleInfrastructureTestCase;
use Shared\Domain\Criteria\Criteria;

final class RedisFruitsRepositoryTest extends FruitModuleInfrastructureTestCase
{
    /** @test */
    public function it_should_save_fruit(): void
    {
        $fruit = FruitMother::create();

        $this->redisRepository()->add($fruit);

        $this->assertCount(1, $this->redisRepository()->list(Criteria::empty())->toArray());
    }

    /** @test */
    public function it_should_fetch_all_fruits(): void
    {
        $fruit1 = FruitMother::create(FruitIdMother::create(1));
        $fruit2 = FruitMother::create(FruitIdMother::create(2));

        $this->redisRepository()->add($fruit1);
        $this->redisRepository()->add($fruit2);

        $this->assertCount(2, $this->redisRepository()->list(Criteria::empty())->toArray());
    }

    /** @test */
    public function it_should_fetch_fruits_by_criteria(): void
    {
        $fruit1 = FruitMother::createWithQuantity(FruitQuantityMother::create(1000), FruitIdMother::create(1));
        $fruit2 = FruitMother::createWithQuantity(FruitQuantityMother::create(1500), FruitIdMother::create(2));

        $this->redisRepository()->add($fruit1);
        $this->redisRepository()->add($fruit2);

        $this->assertCount(1, $this->redisRepository()->list(Criteria::create(
            new FruitIdSpecification($fruit2->id())
        ))->toArray());

        $this->assertCount(1, $this->redisRepository()->list(Criteria::create(
            new FruitNameSpecification($fruit1->name())
        ))->toArray());

        $this->assertCount(2, $this->redisRepository()->list(Criteria::create(
            new FruitMinOrEqualQuantitySpecification($fruit1->quantity())
        ))->toArray());

        $this->assertCount(1, $this->redisRepository()->list(Criteria::create(
            new FruitMinOrEqualQuantitySpecification($fruit2->quantity())
        ))->toArray());

        $this->assertCount(0, $this->redisRepository()->list(Criteria::create(
            new FruitMinOrEqualQuantitySpecification(FruitQuantityMother::create(3000))
        ))->toArray());
    }

    /** @test */
    public function it_should_find_one_fruit(): void
    {
        $fruit = FruitMother::create();

        $this->redisRepository()->add($fruit);

        $this->assertNotNull($this->redisRepository()->find($fruit->id()));
    }

    /** @test */
    public function it_should_remove_one_fruit(): void
    {
        $fruit = FruitMother::create();

        $this->redisRepository()->add($fruit);

        $this->assertCount(1, $this->redisRepository()->list(Criteria::empty())->toArray());

        $this->redisRepository()->delete($fruit->id());

        $this->assertCount(0, $this->redisRepository()->list(Criteria::empty())->toArray());
    }
}