<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Factory\ParameterFactory;

use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;

interface ParameterFactoryInterface
{
    public function setEntityFqcn(string $entityFqcn): ParameterFactoryInterface;

    public function createFromList(RequestParameterList $requestParameterList): array;
}
