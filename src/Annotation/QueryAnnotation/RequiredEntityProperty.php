<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Annotation\QueryAnnotation;

use Maltehuebner\DataQueryBundle\Annotation\AbstractAnnotation;

/**
 * @Annotation
 */
class RequiredEntityProperty extends AbstractAnnotation implements QueryAnnotationInterface
{
    /** @var string $propertyName */
    protected $propertyName;

    /** @var string $propertyType */
    protected $propertyType;

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    public function getPropertyType(): ?string
    {
        return $this->propertyType;
    }
}
