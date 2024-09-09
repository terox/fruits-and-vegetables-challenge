<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Controller\Symfony;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Validation;

abstract class Controller
{
    abstract protected function contentToArray(Request $request): array;

    /**
     * Checks that expected body match with the conditions.
     */
    protected function checkRequestBodyAndReturnPrimitives(Request $request, Constraint $asserts): array
    {
        $data   = $this->contentToArray($request);
        $result = Validation::createValidator()->validate($data, $asserts);

        if(0 === $result->count()) {
            return $data;
        }

        throw new BadRequestException("Something is wrong in the request. Review that the parameters are correct.");
    }
}