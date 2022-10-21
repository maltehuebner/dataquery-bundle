<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Annotation\ParameterAnnotation;

use Maltehuebner\DataQueryBundle\Annotation\AbstractAnnotation;

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
