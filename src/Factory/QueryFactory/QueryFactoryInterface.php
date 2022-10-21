<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Factory\QueryFactory;

use Maltehuebner\DataQueryBundle\RequestParameterList\RequestParameterList;

interface QueryFactoryInterface
{
    public function setEntityFqcn(string $entityFqcn): QueryFactoryInterface;

    public function createFromList(RequestParameterList $requestParameterList): array;
}
