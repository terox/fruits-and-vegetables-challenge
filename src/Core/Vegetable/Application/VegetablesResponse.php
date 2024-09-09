<?php

declare(strict_types=1);

namespace Core\Vegetable\Application;

use Shared\Domain\Response;

final class VegetablesResponse implements Response
{
    /**
     * @var VegetableResponse[]
     */
    private array $responses;

    public function __construct(VegetableResponse ...$responses)
    {
        $this->responses = $responses;
    }

    /**
     *
     * @return VegetableResponse[]
     */
    public function toPrimitives(): array
    {
        return $this->responses;
    }
}