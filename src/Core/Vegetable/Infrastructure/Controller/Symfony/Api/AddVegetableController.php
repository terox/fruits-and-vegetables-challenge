<?php

declare(strict_types=1);

namespace Core\Vegetable\Infrastructure\Controller\Symfony\Api;

use Core\Shared\Domain\ValueObjects\Weight;
use Core\Vegetable\Application\Add\VegetableAdder;
use Core\Vegetable\Domain\VegetableId;
use Core\Vegetable\Domain\VegetableName;
use Core\Vegetable\Domain\VegetableQuantity;
use Shared\Infrastructure\Controller\Symfony\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;

#[Route(
    path:    '/vegetables',
    name:    'fav.ecommerce.api.vegetables.add',
    methods: ['POST']
)]
final class AddVegetableController extends ApiController
{
    public function __construct(
        private readonly VegetableAdder $adder
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $data = $this->checkRequestBodyAndReturnPrimitives($request, $this->validateRequest());

        $this->adder->__invoke(
            new VegetableId($data['id']),
            new VegetableName($data['name']),
            new VegetableQuantity($data['quantity'], $data['unit']),
        );

        return new Response(null, 200);
    }

    protected function validateRequest(): Constraint
    {
        return new Assert\Collection([
            'id'       => [new Assert\Type('int'), new Assert\Positive()],
            'name'     => [new Assert\NotBlank(), new Assert\Length(['min' => 1, 'max' => 255])],
            'quantity' => [new Assert\Type('int'), new Assert\Positive()],
            'unit'     => [new Assert\Choice([Weight::UNIT_GRAM, Weight::UNIT_KILO_GRAMS])]
        ]);
    }
}