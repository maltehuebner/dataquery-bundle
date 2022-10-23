<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Annotation\ParameterAnnotation;

use MalteHuebner\DataQueryBundle\Annotation\AbstractAnnotation;

/**
 * @Annotation
 */
class RequiredParameter extends AbstractAnnotation implements ParameterAnnotationInterface
{
    /** @var string $parameterName */
    protected $parameterName;

    public function getParameterName(): string
    {
        return $this->parameterName;
    }
}
