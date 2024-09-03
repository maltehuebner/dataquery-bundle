<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Attribute\QueryAttribute;

use MalteHuebner\DataQueryBundle\Attribute\AbstractAttribute;

/**
 * @Annotation
 */
class RequiredQueryParameter extends AbstractAttribute implements QueryAttributeInterface
{
    /** @var string $parameterName */
    protected $parameterName;

    public function getParameterName(): string
    {
        return $this->parameterName;
    }
}
