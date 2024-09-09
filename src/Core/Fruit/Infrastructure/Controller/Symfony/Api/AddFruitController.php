<?php

declare(strict_types=1);

namespace Core\Fruit\Infrastructure\Controller\Symfony\Api;

use Core\Fruit\Application\Add\FruitAdder;
use Core\Fruit\Domain\FruitId;
use Core\Fruit\Domain\FruitName;
use Core\Fruit\Domain\FruitQuantity;
use Core\Shared\Domain\ValueObjects\Weight;
use Shared\Infrastructure\Controller\Symfony\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;

#[Route(
    path:    '/fruits',
    name:    'fav.ecommerce.api.fruits.add',
    methods: ['POST']
)]
final class AddFruitController extends ApiController
{
    public function __construct(
        private readonly FruitAdder $adder
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $data = $this->checkRequestBodyAndReturnPrimitives($request, $this->validateRequest());

        $this->adder->__invoke(
            new FruitId($data['id']),
            new FruitName($data['name']),
            new FruitQuantity($data['quantity'], $data['unit']),
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