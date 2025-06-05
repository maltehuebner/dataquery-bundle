<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Attribute\EntityAttribute;

use MalteHuebner\DataQueryBundle\Attribute\AbstractAttribute;

#[\Attribute]
class DefaultBooleanValue extends AbstractAttribute implements EntityAttributeInterface
{
    public function __construct(
        private readonly ?string $alias = null,
        private readonly bool $value = false)
    {

    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }
    
    public function getValue(): bool
    {
        return $this->value;
    }
}
