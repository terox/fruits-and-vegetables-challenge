<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Fruit\Infrastructure\Controller\Symfony\Api;

use Core\Fruit\Application\Add\FruitAdder;
use Core\Fruit\Infrastructure\Controller\Symfony\Api\AddFruitController;
use FAV\Tests\Core\Fruit\FruitModuleUnitTestCase;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class AddFruitControllerUnitTest extends FruitModuleUnitTestCase
{
    private AddFruitController $controller;

    protected function setUp(): void
    {
        $this->controller = new AddFruitController(
            new FruitAdder($this->repository())
        );
    }

    /** @test */
    public function it_should_return_ok_when_input_passes_validators(): void
    {
        $this->repository()
            ->expects('find')
            ->once();

        $this->repository()
            ->expects('add')
            ->once();

        $response = $this->controller->__invoke($this->createPostRequest(
            json_encode([
                'id'       => 1,
                'name'     => 'Im a fruit',
                'quantity' => 1000,
                'unit'     => 'kg'
            ], JSON_THROW_ON_ERROR)
        ));

        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function it_should_return_bad_request_when_unit_is_invalid(): void
    {
        $this->expectException(BadRequestException::class);

        $this->controller->__invoke($this->createPostRequest(
            json_encode([
                'id'       => 1,
                'name'     => 'Im a fruit',
                'quantity' => 1000,
                'unit'     => 'the_unit_not_exist'
            ], JSON_THROW_ON_ERROR)
        ));
    }

    /** @test */
    public function it_should_return_bad_request_when_quantity_is_invalid(): void
    {
        $this->expectException(BadRequestException::class);

        $this->controller->__invoke($this->createPostRequest(
            json_encode([
                'id'       => 1,
                'name'     => 'Im a fruit',
                'quantity' => '1000',
                'unit'     => 'kg'
            ], JSON_THROW_ON_ERROR)
        ));
    }

    /** @test */
    public function it_should_return_bad_request_when_name_is_invalid(): void
    {
        $this->expectException(BadRequestException::class);

        $this->controller->__invoke($this->createPostRequest(
            json_encode([
                'id'       => 1,
                'name'     => '',
                'quantity' => 1000,
                'unit'     => 'kg'
            ], JSON_THROW_ON_ERROR)
        ));
    }

    /** @test */
    public function it_should_return_bad_request_when_id_is_invalid(): void
    {
        $this->expectException(BadRequestException::class);

        $this->controller->__invoke($this->createPostRequest(
            json_encode([
                'id'       => '1',
                'name'     => 'Im a fruit',
                'quantity' => '1000',
                'unit'     => 'kg'
            ], JSON_THROW_ON_ERROR)
        ));
    }

    /** @test */
    public function it_should_return_bad_request_on_malformed_json(): void
    {
        $this->expectException(BadRequestException::class);

        $this->controller->__invoke($this->createPostRequest('{ "id": 1'));
    }

    /** @test */
    public function it_should_return_bad_request_on_invalid_content_type(): void
    {
        $this->expectException(BadRequestException::class);

        $this->controller->__invoke($this->createPostRequest(
            json_encode([
                'id'       => '1',
                'name'     => 'Im a fruit',
                'quantity' => '1000',
                'unit'     => 'kg'
            ], JSON_THROW_ON_ERROR),
            ['content-type' => 'application/form-text']
        ));
    }
}