<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Annotation\QueryAnnotation;

use Maltehuebner\DataQueryBundle\Annotation\AbstractAnnotation;

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
