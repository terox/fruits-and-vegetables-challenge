<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Vegetable\Application\List;

use Core\Shared\Domain\ValueObjects\Weight;
use Core\Vegetable\Application\VegetableResponse;
use Core\Vegetable\Application\List\VegetableLister;
use FAV\Tests\Core\Vegetable\VegetableModuleUnitTestCase;
use Shared\Domain\Criteria\Criteria;

final class VegetableListerUnitTest extends VegetableModuleUnitTestCase
{
    private VegetableLister $lister;

    protected function setUp(): void
    {
        $this->lister = new VegetableLister($this->repository());

        $this->repositoryReturnExampleCollection();
    }

    /** @test */
    public function it_should_list_all_vegetables_with_empty_criteria(): void
    {
        $results = $this->lister->__invoke(Criteria::empty());

        $this->assertCount(3, $results->toPrimitives());
        $this->assertContainsOnlyInstancesOf(VegetableResponse::class, $results->toPrimitives());
    }

    /** @test */
    public function it_should_list_all_vegetables_converted_to_kg(): void
    {
        $results = $this->lister->__invoke(Criteria::empty(), Weight::UNIT_KILO_GRAMS);

        $responses = $results->toPrimitives();

        $this->assertCount(3, $responses);
        $this->assertContainsOnlyInstancesOf(VegetableResponse::class, $responses);
        $this->assertSame(1.0, $responses[0]->quantity);
        $this->assertSame(1.5, $responses[1]->quantity);
        $this->assertSame(5.05, $responses[2]->quantity);
    }
}