<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Factory\ParameterFactory;

use Maltehuebner\DataQueryBundle\RequestParameterList\RequestParameterList;

interface ParameterFactoryInterface
{
    public function setEntityFqcn(string $entityFqcn): ParameterFactoryInterface;

    public function createFromList(RequestParameterList $requestParameterList): array;
}
