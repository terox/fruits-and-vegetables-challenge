<?php

declare(strict_types=1);

namespace Core\Fruit\Application;

use Shared\Domain\Response;

final class FruitsResponse implements Response
{
    /**
     * @var FruitResponse[]
     */
    private array $responses;

    public function __construct(FruitResponse ...$responses)
    {
        $this->responses = $responses;
    }

    /**
     *
     * @return FruitResponse[]
     */
    public function toPrimitives(): array
    {
        return $this->responses;
    }
}