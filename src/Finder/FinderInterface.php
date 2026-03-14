<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Finder;

use MalteHuebner\DataQueryBundle\PaginatedResult\PaginatedResult;

interface FinderInterface
{
    public function executeQuery(array $queryList, array $parameterList): array;
    public function executePaginatedQuery(array $queryList, array $parameterList, int $page, int $size): PaginatedResult;
}
