<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Attribute\QueryAttribute;

use MalteHuebner\DataQueryBundle\Attribute\AbstractAttribute;

class RequiredEntityProperty extends AbstractAttribute implements QueryAttributeInterface
{
    public function __construct(
        private readonly string $propertyName,
        private readonly ?string $propertyType = null
    )
    {

    }

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    public function getPropertyType(): ?string
    {
        return $this->propertyType;
    }
}
