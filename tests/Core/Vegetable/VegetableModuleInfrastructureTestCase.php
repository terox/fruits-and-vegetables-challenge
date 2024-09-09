<?php

declare(strict_types=1);

namespace FAV\Tests\Core\Vegetable;

use Core\Vegetable\Infrastructure\Persistence\Redis\RedisVegetableRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class VegetableModuleInfrastructureTestCase extends KernelTestCase
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

    protected function redisRepository(): RedisVegetableRepository
    {
        return $this->service(RedisVegetableRepository::class);
    }

    protected function service(string $id): mixed
    {
        return self::getContainer()->get($id);
    }
}