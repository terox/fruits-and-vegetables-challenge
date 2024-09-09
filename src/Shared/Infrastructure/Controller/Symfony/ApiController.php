<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Controller\Symfony;

use Shared\Domain\Response;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class ApiController extends Controller
{
    protected function contentToArray(Request $request): array
    {
        if('json' !== $request->getContentTypeFormat()) {
            throw new BadRequestException('The content type must be <application/json>');
        }

        try {
            return json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch(\JsonException) {
            throw new BadRequestException('The JSON content is malformed');
        }
    }

    protected function response(Response $response, int $status = 200): JsonResponse
    {
        return new JsonResponse(
            array_map(
                static fn ($item) => $item instanceof Response ? $item->toPrimitives() : $item,
                $response->toPrimitives()
            ),
            $status
        );
    }
}