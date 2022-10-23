<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Factory\QueryFactory;

use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;

interface QueryFactoryInterface
{
    public function setEntityFqcn(string $entityFqcn): QueryFactoryInterface;

    public function createFromList(RequestParameterList $requestParameterList): array;
}
