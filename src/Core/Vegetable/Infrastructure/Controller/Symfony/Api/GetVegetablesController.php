<?php

declare(strict_types=1);

namespace Core\Vegetable\Infrastructure\Controller\Symfony\Api;

use Core\Shared\Domain\ValueObjects\Weight;
use Core\Vegetable\Application\List\VegetableLister;
use Core\Vegetable\Domain\Criteria\CriteriaFactory;
use Shared\Infrastructure\Controller\Symfony\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/vegetables',
    name: 'fav.ecommerce.api.vegetables.list',
    methods: ['GET']
)]
final class GetVegetablesController extends ApiController
{
    public function __construct(
        private readonly VegetableLister $lister
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $criteria = CriteriaFactory::fromArray($request->query->all());

        $vegetables = $this->lister->__invoke($criteria, $request->query->getString('unit', Weight::UNIT_GRAM));

        return $this->response($vegetables);
    }
}