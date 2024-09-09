<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\Redis;

use Core\Shared\Domain\Collection;
use Core\Shared\Domain\Item;
use Redis;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\ValueObject\Identity;
use Shared\Infrastructure\Persistence\BaseRepository;

abstract class RedisRepository extends BaseRepository
{
    public function __construct(
        private readonly Redis $client,
        private readonly string $prefix
    ) {
    }

    abstract protected function convertToCollection(array $results): Collection;

    protected function remove(Identity $identity): void
    {
        $this->client->hDel($this->prefix, (string)$identity->value());
    }

    protected function save(Item $item): void
    {
        $this->client->hSet(
            $this->prefix,
            (string)$item->id()->value(),
            json_encode($item->toPrimitives())
        );
    }

   protected function fetch(Criteria $criteria): Collection
    {
        $results = $this->client->hGetAll($this->prefix);

        if(false === $results) {
            return $this->convertToCollection([]);
        }

        // Decode the results
        return $this
            ->convertToCollection(array_map(
                static fn(string $raw) => json_decode($raw, true),
                $results
            ))
            ->filter($criteria);
    }
}