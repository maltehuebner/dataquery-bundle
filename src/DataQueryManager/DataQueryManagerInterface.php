<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\DataQueryManager;

use MalteHuebner\DataQueryBundle\PaginatedResult\PaginatedResult;
use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;

interface DataQueryManagerInterface
{
    public function query(RequestParameterList $requestParameterList, string $entityFqcn): array;
    public function paginatedQuery(RequestParameterList $requestParameterList, string $entityFqcn): PaginatedResult;
}
