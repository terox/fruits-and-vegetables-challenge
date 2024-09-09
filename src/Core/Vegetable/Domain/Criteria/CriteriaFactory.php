<?php

declare(strict_types=1);

namespace Core\Vegetable\Domain\Criteria;

use Core\Vegetable\Domain\VegetableId;
use Core\Vegetable\Domain\VegetableName;
use Core\Vegetable\Domain\VegetableQuantity;
use Shared\Domain\Criteria\Criteria;

final class CriteriaFactory
{
    public static function fromArray(array $filters): Criteria
    {
        $specifications = [];

        if(isset($filters['id'])) {
            $specifications[] = new VegetableIdSpecification(new VegetableId((int)$filters['id']));
        }

        if(isset($filters['name'])) {
            $specifications[] = new VegetableNameSpecification(new VegetableName($filters['name']));
        }

        if(isset($filters['quantity'])) {
            $specifications[] = new VegetableMinOrEqualQuantitySpecification(new VegetableQuantity((float)$filters['quantity'], 'g'));
        }

        return Criteria::create(...$specifications);
    }
}