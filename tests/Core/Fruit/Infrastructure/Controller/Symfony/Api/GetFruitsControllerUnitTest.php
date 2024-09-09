<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Fruit\Infrastructure\Controller\Symfony\Api;

use Core\Fruit\Application\List\FruitLister;
use Core\Fruit\Infrastructure\Controller\Symfony\Api\GetFruitsController;
use FAV\Tests\Core\Fruit\FruitModuleUnitTestCase;

final class GetFruitsControllerUnitTest extends FruitModuleUnitTestCase
{
    private GetFruitsController $controller;

    protected function setUp(): void
    {
        $this->controller = new GetFruitsController(
            new FruitLister($this->repository())
        );

        $this->repositoryReturnExampleCollection();
    }

    /** @test */
    public function it_should_return_ok_and_results_when_no_criteria(): void
    {
        $response = $this->controller->__invoke($this->createGetRequest());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Hello World Fruit 1', $response->getContent());
        $this->assertStringContainsString('Hello World Fruit 2', $response->getContent());
        $this->assertStringContainsString('Hello World Fruit 500', $response->getContent());
    }

    /** @test */
    public function it_should_results_converted_to_kg(): void
    {
        $response = $this->controller->__invoke($this->createGetRequest([ 'unit' => 'kg' ]));

        $results = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(1.0, $results[0]['quantity']);
        $this->assertEquals('kg', $results[0]['unit']);

        $this->assertEquals(1.5, $results[1]['quantity']);
        $this->assertEquals('kg', $results[1]['unit']);

        $this->assertEquals(5.05, $results[2]['quantity']);
        $this->assertEquals('kg', $results[2]['unit']);
    }
}