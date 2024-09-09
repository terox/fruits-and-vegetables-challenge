<?php
declare(strict_types=1);

namespace Core\Fruit\Application;

use Core\Fruit\Domain\Fruit;

final readonly class FruitResponseConverter
{
    public function __construct(
        private string $quantityUnit
    ) {
    }

    public function __invoke(Fruit $fruit): FruitResponse
    {
        return new FruitResponse(
            $fruit->id()->value(),
            $fruit->name()->value(),
            $fruit->quantity()->convertTo($this->quantityUnit),
            $this->quantityUnit
        );
    }
}