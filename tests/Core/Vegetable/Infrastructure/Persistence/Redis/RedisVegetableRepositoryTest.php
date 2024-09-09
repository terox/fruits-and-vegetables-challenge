<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Vegetable\Infrastructure\Persistence\Redis;

use Core\Vegetable\Domain\Criteria\VegetableIdSpecification;
use Core\Vegetable\Domain\Criteria\VegetableMinOrEqualQuantitySpecification;
use Core\Vegetable\Domain\Criteria\VegetableNameSpecification;
use FAV\Tests\Core\Vegetable\Domain\VegetableIdMother;
use FAV\Tests\Core\Vegetable\Domain\VegetableMother;
use FAV\Tests\Core\Vegetable\Domain\VegetableQuantityMother;
use FAV\Tests\Core\Vegetable\VegetableModuleInfrastructureTestCase;
use Shared\Domain\Criteria\Criteria;

final class RedisVegetableRepositoryTest extends VegetableModuleInfrastructureTestCase
{
    /** @test */
    public function it_should_save_vegetable(): void
    {
        $vegetable = VegetableMother::create();

        $this->redisRepository()->add($vegetable);

        $this->assertCount(1, $this->redisRepository()->list(Criteria::empty())->toArray());
    }

    /** @test */
    public function it_should_fetch_all_vegetables(): void
    {
        $vegetable1 = VegetableMother::create(VegetableIdMother::create(1));
        $vegetable2 = VegetableMother::create(VegetableIdMother::create(2));

        $this->redisRepository()->add($vegetable1);
        $this->redisRepository()->add($vegetable2);

        $this->assertCount(2, $this->redisRepository()->list(Criteria::empty())->toArray());
    }

    /** @test */
    public function it_should_fetch_vegetables_by_criteria(): void
    {
        $vegetable1 = VegetableMother::createWithQuantity(VegetableQuantityMother::create(1000), VegetableIdMother::create(1));
        $vegetable2 = VegetableMother::createWithQuantity(VegetableQuantityMother::create(1500), VegetableIdMother::create(2));

        $this->redisRepository()->add($vegetable1);
        $this->redisRepository()->add($vegetable2);

        $this->assertCount(1, $this->redisRepository()->list(Criteria::create(
            new VegetableIdSpecification($vegetable2->id())
        ))->toArray());

        $this->assertCount(1, $this->redisRepository()->list(Criteria::create(
            new VegetableNameSpecification($vegetable1->name())
        ))->toArray());

        $this->assertCount(2, $this->redisRepository()->list(Criteria::create(
            new VegetableMinOrEqualQuantitySpecification($vegetable1->quantity())
        ))->toArray());

        $this->assertCount(1, $this->redisRepository()->list(Criteria::create(
            new VegetableMinOrEqualQuantitySpecification($vegetable2->quantity())
        ))->toArray());

        $this->assertCount(0, $this->redisRepository()->list(Criteria::create(
            new VegetableMinOrEqualQuantitySpecification(VegetableQuantityMother::create(3000))
        ))->toArray());
    }

    /** @test */
    public function it_should_find_one_vegetable(): void
    {
        $vegetable = VegetableMother::create();

        $this->redisRepository()->add($vegetable);

        $this->assertNotNull($this->redisRepository()->find($vegetable->id()));
    }

    /** @test */
    public function it_should_remove_one_Vegetable(): void
    {
        $vegetable = VegetableMother::create();

        $this->redisRepository()->add($vegetable);

        $this->assertCount(1, $this->redisRepository()->list(Criteria::empty())->toArray());

        $this->redisRepository()->delete($vegetable->id());

        $this->assertCount(0, $this->redisRepository()->list(Criteria::empty())->toArray());
    }
}