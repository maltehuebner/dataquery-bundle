<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class EntityNotFoundException extends DataQueryException implements HttpExceptionInterface
{
    public function __construct(string $parameterName, string $parameterValue)
    {
        $message = sprintf('Could not find entity for query parameter "%s" with value "%s"', $parameterName, $parameterValue);

        parent::__construct($message);
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
