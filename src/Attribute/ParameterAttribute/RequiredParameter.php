<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Attribute\ParameterAttribute;

use MalteHuebner\DataQueryBundle\Attribute\AbstractAttribute;

/**
 * @Annotation
 */
class RequiredParameter extends AbstractAttribute implements ParameterAttributeInterface
{
    /** @var string $parameterName */
    protected $parameterName;

    public function getParameterName(): string
    {
        return $this->parameterName;
    }
}
