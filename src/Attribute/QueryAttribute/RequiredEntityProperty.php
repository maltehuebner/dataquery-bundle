<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Attribute\QueryAttribute;

use MalteHuebner\DataQueryBundle\Attribute\AbstractAttribute;

/**
 * @Annotation
 */
class RequiredEntityProperty extends AbstractAttribute implements QueryAttributeInterface
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
