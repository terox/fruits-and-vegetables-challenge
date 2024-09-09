<?php
declare(strict_types=1);

namespace Core\Vegetable\Application;

use Core\Vegetable\Domain\Vegetable;

final readonly class VegetableResponseConverter
{
    public function __construct(
        private string $quantityUnit
    ) {
    }

    public function __invoke(Vegetable $vegetable): VegetableResponse
    {
        return new VegetableResponse(
            $vegetable->id()->value(),
            $vegetable->name()->value(),
            $vegetable->quantity()->convertTo($this->quantityUnit),
            $this->quantityUnit
        );
    }
}