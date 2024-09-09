<?php

declare(strict_types=1);

namespace Core\Vegetable\Application;

use Shared\Domain\Response;

final readonly class VegetableResponse implements Response
{
    public function __construct(
        public int $id,
        public string $name,
        public float $quantity,
        public string $unit,
    ) {
    }

    public function toPrimitives(): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'quantity' => $this->quantity,
            'unit'     => $this->unit,
        ];
    }
}