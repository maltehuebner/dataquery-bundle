<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\DataQueryManager;

use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;

interface DataQueryManagerInterface
{
    public function query(RequestParameterList $requestParameterList, string $entityFqcn): array;
}