<?php

declare(strict_types=1);

namespace Core\Fruit\Infrastructure\Persistence\Redis;

use Core\Fruit\Domain\Criteria\FruitIdSpecification;
use Core\Fruit\Domain\Fruit;
use Core\Fruit\Domain\FruitId;
use Core\Fruit\Domain\FruitRepository;
use Core\Fruit\Domain\Fruits;
use Core\Shared\Domain\Collection;
use Redis;
use Shared\Domain\Criteria\Criteria;
use Shared\Infrastructure\Persistence\Redis\RedisRepository;

final class RedisFruitRepository extends RedisRepository implements FruitRepository
{
    public function __construct(Redis $client)
    {
        parent::__construct($client, 'fruits');
    }

    public function convertToCollection(array $results): Collection
    {
        return new Fruits(array_map(static fn(array $item) => Fruit::fromArray($item), $results));
    }

    public function find(FruitId $id): ?Fruit
    {
        return $this
            ->fetch(Criteria::create(new FruitIdSpecification($id)))
            ->getOneOrNull(0);
    }

    public function add(Fruit $item): void
    {
        $this->save($item);
    }

    public function list(Criteria $criteria): Fruits
    {
        return $this->fetch($criteria);
    }

    public function delete(FruitId $id): void
    {
        $this->remove($id);
    }
}