<?php

declare(strict_types=1);

namespace FAV\Tests\Shared\Infrastructure\Testing\PHPUnit;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class TestCase extends MockeryTestCase
{
    protected function createPostRequest(string $content, ?array $headers = null): Request
    {
        return new Request(
            [],
            [],
            [],
            [],
            [],
            $headers ?? ['CONTENT_TYPE' => 'application/json'],
            $content
        );
    }

    protected function createGetRequest(array $query = []): Request
    {
        return new Request($query);
    }

    protected function mock(string $class): MockInterface
    {
        return \Mockery::mock($class);
    }
}