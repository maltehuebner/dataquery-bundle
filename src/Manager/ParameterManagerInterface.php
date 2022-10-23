<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Manager;

use MalteHuebner\DataQueryBundle\Parameter\ParameterInterface;

interface ParameterManagerInterface
{
    public function addParameter(ParameterInterface $parameter): ParameterManagerInterface;

    public function getParameterList(): array;
}
