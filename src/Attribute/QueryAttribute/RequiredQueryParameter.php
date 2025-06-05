<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Attribute\QueryAttribute;

use MalteHuebner\DataQueryBundle\Attribute\AbstractAttribute;

class RequiredQueryParameter extends AbstractAttribute implements QueryAttributeInterface
{
    public function __construct(private readonly string $parameterName)
    {

    }

    public function getParameterName(): string
    {
        return $this->parameterName;
    }
}
