<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Annotation\EntityAnnotation;

use Maltehuebner\DataQueryBundle\Annotation\AbstractAnnotation;

/**
 * @Annotation
 */
class DefaultBooleanValue extends AbstractAnnotation implements EntityAnnotationInterface
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
