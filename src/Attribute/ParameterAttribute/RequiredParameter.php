<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Attribute\ParameterAttribute;

use MalteHuebner\DataQueryBundle\Attribute\AbstractAttribute;

class RequiredParameter extends AbstractAttribute implements ParameterAttributeInterface
{
    public function __construct(private readonly string $parameterName)
    {

    }

    public function getParameterName(): string
    {
        return $this->parameterName;
    }
}
