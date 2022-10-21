<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Manager;

use Maltehuebner\DataQueryBundle\Parameter\ParameterInterface;

interface ParameterManagerInterface
{
    public function addParameter(ParameterInterface $parameter): ParameterManagerInterface;

    public function getParameterList(): array;
}
