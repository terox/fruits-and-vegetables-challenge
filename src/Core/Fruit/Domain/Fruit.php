<?php

declare(strict_types=1);

namespace Core\Fruit\Domain;

use Core\Shared\Domain\Item;
use Core\Shared\Domain\ValueObjects\Weight;

final readonly class Fruit implements Item
{
    private function __construct(
        private FruitId $id,
        private FruitName $name,
        private FruitQuantity $quantity
    ) {
    }

    public static function create(
        FruitId $id,
        FruitName $name,
        FruitQuantity $quantity
    ): self {
        // We could register here and event to announce the new item in the application
        return new self($id, $name, $quantity);
    }

    public static function fromArray(array $item): self
    {
        return new self(
            new FruitId($item['id']),
            new FruitName($item['name']),
            new FruitQuantity($item['quantity'], $item['unit'])
        );
    }

    public function id(): FruitId
    {
        return $this->id;
    }

    public function name(): FruitName
    {
        return $this->name;
    }

    public function quantity(): FruitQuantity
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