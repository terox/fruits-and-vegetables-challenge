<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Fruit;

use Core\Fruit\Infrastructure\Persistence\Redis\RedisFruitRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class FruitModuleInfrastructureTestCase extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel([
            'environment' => 'test',
            'debug'       => false
        ]);

        // Clear databases
        $this->service('shared.redis.client')->flushAll();

        parent::setUp();
    }

    protected function redisRepository(): RedisFruitRepository
    {
        return $this->service(RedisFruitRepository::class);
    }

    protected function service(string $id): mixed
    {
        return self::getContainer()->get($id);
    }
}