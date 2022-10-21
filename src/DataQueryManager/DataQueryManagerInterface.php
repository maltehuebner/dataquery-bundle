<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\DataQueryManager;

use Maltehuebner\DataQueryBundle\RequestParameterList\RequestParameterList;

interface DataQueryManagerInterface
{
    public function query(RequestParameterList $requestParameterList, string $entityFqcn): array;
}