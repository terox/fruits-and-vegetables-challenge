<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Fruit\Application\List;

use Core\Fruit\Application\FruitResponse;
use Core\Fruit\Application\List\FruitLister;
use Core\Shared\Domain\ValueObjects\Weight;
use FAV\Tests\Core\Fruit\FruitModuleUnitTestCase;
use Shared\Domain\Criteria\Criteria;

final class FruitListerUnitTest extends FruitModuleUnitTestCase
{
    private FruitLister $lister;

    protected function setUp(): void
    {
        $this->lister = new FruitLister($this->repository());

        $this->repositoryReturnExampleCollection();
    }

    /** @test */
    public function it_should_list_all_fruits_with_empty_criteria(): void
    {
        $results = $this->lister->__invoke(Criteria::empty());

        $this->assertCount(3, $results->toPrimitives());
        $this->assertContainsOnlyInstancesOf(FruitResponse::class, $results->toPrimitives());
    }

    /** @test */
    public function it_should_list_all_fruits_converted_to_kg(): void
    {
        $results = $this->lister->__invoke(Criteria::empty(), Weight::UNIT_KILO_GRAMS);

        $responses = $results->toPrimitives();

        $this->assertCount(3, $responses);
        $this->assertContainsOnlyInstancesOf(FruitResponse::class, $responses);
        $this->assertSame(1.0, $responses[0]->quantity);
        $this->assertSame(1.5, $responses[1]->quantity);
        $this->assertSame(5.05, $responses[2]->quantity);
    }
}