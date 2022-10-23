<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Annotation\QueryAnnotation;

use MalteHuebner\DataQueryBundle\Annotation\AbstractAnnotation;

/**
 * @Annotation
 */
class RequiredQueryParameter extends AbstractAnnotation implements QueryAnnotationInterface
{
    /** @var string $parameterName */
    protected $parameterName;

    public function getParameterName(): string
    {
        return $this->parameterName;
    }
}
