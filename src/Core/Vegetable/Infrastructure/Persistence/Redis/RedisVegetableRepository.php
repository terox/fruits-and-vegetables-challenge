<?php

declare(strict_types=1);

namespace Core\Vegetable\Infrastructure\Persistence\Redis;

use Core\Shared\Domain\Collection;
use Core\Vegetable\Domain\Criteria\VegetableIdSpecification;
use Core\Vegetable\Domain\Vegetable;
use Core\Vegetable\Domain\VegetableId;
use Core\Vegetable\Domain\VegetableRepository;
use Core\Vegetable\Domain\Vegetables;
use Redis;
use Shared\Domain\Criteria\Criteria;
use Shared\Infrastructure\Persistence\Redis\RedisRepository;

final class RedisVegetableRepository extends RedisRepository implements VegetableRepository
{
    public function __construct(Redis $client)
    {
        parent::__construct($client, 'vegetables');
    }

    public function convertToCollection(array $results): Collection
    {
        return new Vegetables(array_map(static fn(array $item) => Vegetable::fromArray($item), $results));
    }

    public function find(VegetableId $id): ?Vegetable
    {
        return $this
            ->fetch(Criteria::create(new VegetableIdSpecification($id)))
            ->getOneOrNull(0);
    }

    public function add(Vegetable $item): void
    {
        $this->save($item);
    }

    public function list(Criteria $criteria): Vegetables
    {
        return $this->fetch($criteria);
    }

    public function delete(VegetableId $id): void
    {
        $this->remove($id);
    }
}