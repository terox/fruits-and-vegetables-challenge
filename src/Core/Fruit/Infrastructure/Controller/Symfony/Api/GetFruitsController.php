<?php

declare(strict_types=1);

namespace Core\Fruit\Infrastructure\Controller\Symfony\Api;

use Core\Fruit\Application\List\FruitLister;
use Core\Fruit\Domain\Criteria\CriteriaFactory;
use Core\Shared\Domain\ValueObjects\Weight;
use Shared\Infrastructure\Controller\Symfony\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/fruits',
    name: 'fav.ecommerce.api.fruits.list',
    methods: ['GET']
)]
final class GetFruitsController extends ApiController
{
    public function __construct(
        private readonly FruitLister $lister
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $criteria = CriteriaFactory::fromArray($request->query->all());

        $fruits = $this->lister->__invoke($criteria, $request->query->getString('unit', Weight::UNIT_GRAM));

        return $this->response($fruits);
    }
}