<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Manager;

use MalteHuebner\DataQueryBundle\Parameter\ParameterInterface;

class ParameterManager implements ParameterManagerInterface
{
    private array $parameterList = [];

    #[\Override]
    public function addParameter(ParameterInterface $parameter): ParameterManagerInterface
    {
        $this->parameterList[] = $parameter;

        return $this;
    }

    #[\Override]
    public function getParameterList(): array
    {
        return $this->parameterList;
    }
}
