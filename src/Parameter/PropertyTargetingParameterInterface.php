<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Parameter;

interface PropertyTargetingParameterInterface extends ParameterInterface
{
    public function getPropertyName(): string;
}
