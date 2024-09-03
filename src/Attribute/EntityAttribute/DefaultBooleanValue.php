<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Attribute\EntityAttribute;

use MalteHuebner\DataQueryBundle\Attribute\AbstractAttribute;

/**
 * @Annotation
 */
class DefaultBooleanValue extends AbstractAttribute implements EntityAttributeInterface
{
    /** @var string $alias */
    protected $alias;

    /** @var bool $value */
    protected $value;

    public function getAlias(): ?string
    {
        return $this->alias;
    }
    
    public function getValue(): bool
    {
        return $this->value;
    }
}
