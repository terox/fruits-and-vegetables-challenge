<?php

declare(strict_types=1);

namespace Core\Vegetable\Domain;

use Core\Shared\Domain\Item;
use Core\Shared\Domain\ValueObjects\Weight;

final readonly class Vegetable implements Item
{
    private function __construct(
        private VegetableId       $id,
        private VegetableName     $name,
        private VegetableQuantity $quantity
    ) {
    }

    public static function create(
        VegetableId       $id,
        VegetableName     $name,
        VegetableQuantity $quantity
    ): self {
        // We could register here and event to announce the new item in the application
        return new self($id, $name, $quantity);
    }

    public static function fromArray(array $item): self
    {
        return new self(
            new VegetableId($item['id']),
            new VegetableName($item['name']),
            new VegetableQuantity($item['quantity'], $item['unit'])
        );
    }

    public function id(): VegetableId
    {
        return $this->id;
    }

    public function name(): VegetableName
    {
        return $this->name;
    }

    public function quantity(): VegetableQuantity
    {
        return $this->quantity;
    }

    public function toPrimitives(): array
    {
        return [
            'id'       => $this->id()->value(),
            'name'     => $this->name()->value(),
            'quantity' => $this->quantity()->toGrams(),
            'unit'     => Weight::UNIT_GRAM
        ];
    }
}