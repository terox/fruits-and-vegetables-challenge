<?php

declare(strict_types=1);

namespace Core\Fruit\Domain\Criteria;

use Core\Fruit\Domain\FruitId;
use Core\Fruit\Domain\FruitName;
use Core\Fruit\Domain\FruitQuantity;
use Shared\Domain\Criteria\Criteria;

final class CriteriaFactory
{
    public static function fromArray(array $filters): Criteria
    {
        $specifications = [];

        if(isset($filters['id'])) {
            $specifications[] = new FruitIdSpecification(new FruitId((int)$filters['id']));
        }

        if(isset($filters['name'])) {
            $specifications[] = new FruitNameSpecification(new FruitName($filters['name']));
        }

        if(isset($filters['quantity'])) {
            $specifications[] = new FruitMinOrEqualQuantitySpecification(new FruitQuantity((float)$filters['quantity'], 'g'));
        }

        return Criteria::create(...$specifications);
    }
}