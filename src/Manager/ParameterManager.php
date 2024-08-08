<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Manager;

use MalteHuebner\DataQueryBundle\Parameter\ParameterInterface;

class ParameterManager implements ParameterManagerInterface
{
    /** @var array $parameterList */
    protected $parameterList = [];

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
